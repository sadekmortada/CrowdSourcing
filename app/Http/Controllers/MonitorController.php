<?php

namespace App\Http\Controllers;
use App\Workshop;
use App\Card;
use App\Voting;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

class MonitorController extends Controller
{
    public function __construct(){
        $this->middleware('monitorplus')->only(['monitorworkshop','joindoor','takecards','takescores','shuffilecards','results','chooseproject']);
    }
    public function createworkshop() {
        return view('monitor.createworkshop');
    }

    public function storeworkshop() {
        $workshop = request()->validate([
            'title' => 'string|required|max:50',
            'body' => 'required|max:500',
            'participants' => 'integer|min:6'
        ]);

        $workshop['workshop_key'] = Hash::make($workshop['title']);
        $workshop['user_id'] = auth()->user()->id;
        $workshop = Workshop::create($workshop);

        Auth::user()->can_submit=0;
        Auth::user()->can_vote=0;
        Auth::user()->save();
        session()->flash('success','Workshop Created Successfuly');
        return redirect(route('monitorworkshop' , $workshop->id));
    }
    public function monitorworkshop(Workshop $workshop) {
        if($workshop->stage!=0)
            return redirect(route('takecards', $workshop->id));
        return view('monitor.monitorworkshop',[
            'users'=>$workshop->users,
            'workshop'=>$workshop
       ]);
    }
    public function joindoor(Workshop $workshop){ // Lock/open the workshop Door
        if($workshop->stage!=0)
            return redirect(route('takecards', $workshop->id));
        if($workshop->locked==0){
            $workshop->locked=1;
            session()->flash('success','Workshop Door Closed Succefully');
         }
        else{
            $workshop->locked=0;
            session()->flash('success','Workshop Door Opened Succefully');
        }
        $workshop->save();
        return redirect(route('monitorworkshop',$workshop->id));
    }
    public function takecards(Workshop $workshop){
        if($workshop->stage==0 && $workshop->locked==1){
            $users=$workshop->users; //collection of particpants of this workshop
            foreach($users as $user){
                // allow ech user to submit a card when user submit his card its turned to 0 again
                $user->can_submit = 1;
                $user->save();
            }
            // change can submit to the monitor
            auth()->user()->can_submit = 1;
            auth()->user()->save();
            // notify each participant to submit his card
            event(new \App\Events\MyEvent('Workshop started, submit your card','participants'.$workshop->id));
            $workshop->stage=1;
            $workshop->save();
        }
        if($workshop->stage!=1)
            return redirect(route('takescores', $workshop->id));
        return view('monitor.takecards',[
            'workshop'=>$workshop
            ]);
    }
    public function takescores(Workshop $workshop){
        if($workshop->stage!=2)
            return redirect(route('results', $workshop->id));
        return view('monitor.takescores',[
            'workshop'=>$workshop
        ]);
    }
    public function shuffilecards(Workshop $workshop){
        if($workshop->stage!=2)
            return redirect(route('results', $workshop->id));
        $workshop->voted=0;
        $workshop->save();
        auth()->user()->can_vote=1;
        auth()->user()->save();
        $users=$workshop->users; //collection of particpants of this workshop
        $cards=Card::where('workshop_id',$workshop->id)->get(); // collection of cards associated to this workshop
        $takenCards=Collect(new Card);
        $currentVotes=(Collect(new Voting))->values();
        foreach($users as $user){
            $user->can_vote=1;
            $user->save();
            $votings=Voting::where([['user_id',$user->id],['workshop_id',$workshop->id]])->get();
            $votedCards=Collect(new Card);
            foreach($votings as $vote)
                $votedCards->push(Card::where('id',$vote->card_id)->first());
            $votedCards->push(Card::where([['workshop_id',$workshop->id],['user_id',$user->id]])->first());
            $availableCards=($cards->diff($votedCards))->diff($takenCards); // remove taken cards and voted cards from workshop cards
            $availableCards=$availableCards->values(); // this method is used to arrange cards in the collection
            if($availableCards==null||$availableCards->count()==0){ // case null, must delete uploaded votes and reshuffile
                foreach($currentVotes as $v)
                    $v->delete();
                $currentVotes=(Collect(new Voting))->values();
                return $this->shuffilecards($workshop);
            }
            $random=rand(0,($availableCards->count())-1); // choosing random card from the available cards
            $currentVotes->push(Voting::create([ // putting the card in the voting table and adding it to the current votes, current votes used ONLY when we need to reshuffile
                'user_id'=>$user->id,
                'card_id'=>$availableCards[$random]->id,
                'workshop_id'=>$workshop->id
            ]));
            $takenCards->push($availableCards[$random]); // add the card to the taken cards
        }
        // inform each participant to vote on distributed card
        event(new \App\Events\MyEvent('Cards distributed, you can vote now','participants'.$workshop->id));
        return redirect(route('takescores',$workshop->id));
    }
    public function results(Workshop $workshop){
        if($workshop->stage!=3)
            return redirect(route('monitorworkshop', $workshop->id));
        $cards=Card::where('workshop_id',$workshop->id)->orderBy('score','desc')->get();
        return view('monitor.results',[
            'cards'=>$cards,
            'workshop'=>$workshop
        ]);
    }
    public function chooseproject(Workshop $workshop,Card $card){
        if($workshop->stage!=3)
            return redirect(route('monitorworkshop', $workshop->id));
        $cards=Card::where('workshop_id',$workshop->id)->orderBy('score','desc')->get();
        $participants=$workshop->users;
        $projects=$workshop->projects;

        $participants=$participants->keyBy('id');

        foreach ($projects as $project){
            $participants->forget($project->user_id);
        }
        $projectMembers = $card->members;

        return view('monitor.results',[
            'project'=>$card,
            'cards'=>$cards,
            'workshop'=>$workshop,
            'participants'=>$participants,
            'members' => $projectMembers
        ]);
    }

    public function addmembers(Workshop $workshop ,Card $card){
        if($workshop->stage!=3)
            return redirect(route('monitorworkshop', $workshop->id));
        $members = request('members');
        Project::where('card_id',$card->id)->delete();
        $card->takenAsProject=0;
        if($members){ // card taken as project, associate the project with its members(participants) in the projects table
            $card->takenAsProject=1;
            foreach ($members as $member){
                Project::create([
                    'user_id'=>$member,
                    'card_id'=>$card->id,
                    'workshop_id'=>$workshop->id
                ]);

                // inform all members to check their projects
                event(new \App\Events\MyEvent('You are in a group now, check your project','participant'.$member));
            }
        }
        $card->save();
        return redirect(route('results',$workshop->id));
    }

}
