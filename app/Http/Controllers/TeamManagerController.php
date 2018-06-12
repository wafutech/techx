<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use App\UserInTeam;
use App\TeamSkill;
use Auth;
use Event;
use App\Events\AddedToAteamEvent;
use App\Events\UserRemovedFromTeamEvent;
use App\Events\InviteUserIntoTeamEvent;
use DB;


class TeamManagerController extends Controller
{
    /** Adds new user to an existing team**/
    public function addUser()
    {
    	$user = $request->user;
    	$owner = Auth::user()->id;
    	$team = $request->team;
    	$is_owner = Team::where('owner',$owner)->where('id',$team)->first();
    	if($is_owner)
    	{
    		$newUser = new UserInTeam;
    		$newUser->user_id = $user;
    		$newUser->team_id = $team;
    		$newUser->save();
    	//Fire an event to inform the user that has been added to this team
    			Fire::Even(new AddedToAteamEvent($team,$user,$owner));
    		return 'User Added!';

    	}

    }

    /**Removes user from existing team**/
    public function removeUser(Request $request)
    {
    	$user = $request->user;
    	$owner = Auth::user()->id;
    	$team = $request->team;

    	$is_owner = Team::where('owner',$owner)->where('id',$team)->first();
    	if($is_owner)
    	{
    	$removeUser = UserInTeam::where('team_id',$team)->where('user_id',$user)->first();
    	$removeUser = $removeUser->delete();

    	//Fire event to send an invitation notification
    		Fire::Even(new UserRemovedFromTeamEvent($team,$user,$owner));
    		return 'User Removed!';
    	}
    }

    /** Invite user or users to join a team**/

    public function inviteUsers(Request $request)
    {
    	$team = $request->team;
    	$user = $request->user;
    	$owner = Auth::user()->id;
    	$is_owner = Team::where('owner',$owner)->where('id',$team)->first();
    	if($is_owner)
    	{
    	//Fire event to send an invitation notification
    		Fire::Even(new InviteUserIntoTeamEvent($team,$user,$owner));
    		return 'Invitation sent!';
    	}

    	return 'Something Went Wrong!';
    }

    /**Exit from a team**/

    public function exit(Request $request, $team)
    {
    	$user = Auth::user()->id;
    	$team = UserInTeam::where('user_id',$user)->where('team_id',$team);
    	if($team)
    	{
    		return $team->delete();
    	}

    	return 'Request Failed!';

    }

    /**List teams for each user **/

    public function userTeams()
    {
    	$teams = DB::table('user_in_teams')
    				->join('teams','user_in_teams.team_id','teams.id','user_in_teams.team_id')
    				->where('user_in_teams.user_id',Auth::user()->id)
    				->get();
    	     return $teams;
    }

/**Adds skills to a team*/
    public function addSkills(Request $request)
    {
     $team = $request->team;
    	$skill = $request->skill;
    	$owner = Auth::user()->id;
    	$is_owner = Team::where('owner',$owner)->where('id',$team)->first();
    	if($is_owner)
    	{
    	//check if the team already has the skill assigned
    		$teamHasSkill = TeamSkill::where('team_id',$team)->where('skill',$skill)->first();
    		if($teamHasSkill)
    		{
    			return 'Skill Already Added!';
    		}
    	$teamSkill = new TeamSkill;
    	$teamSkill->team_id = $team;
    	$teamSkill->skill = $skill;
    	$teamSkill->save();
    	return 'success';

    	}

    	return 'Something Went Wrong!';
    }

    /** Removes skills from a team */
    public function removeSkills()
    {
    	$team = $request->team;
    	$skill = $request->skill;
    	$owner = Auth::user()->id;
    	$is_owner = Team::where('owner',$owner)->where('id',$team)->first();
    	if($is_owner)
    	{
    		$skill = TeamSkill::where('team_id',$team)->where('skill',$skill)->first();
    		$skill->delete();
    		return 'Skill Removed!';
    	}

    	return 'Failed';
    }


}
