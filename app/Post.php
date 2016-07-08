<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Auth;


class Post extends Model
{
    public function Reactions()
    {
        return $this->hasMany('App\PostReaction');
    }
    
    public function Emotions()
    {
        return $this->hasMany('App\PostEmotion');
    }
    
    public function Comments()
    {
        return $this->hasMany('App\PostComment');
    }
    
    public function User()
    {
        return $this->belongsTo('App\User');
    }
    
    public function Stream($profile = FALSE, $offset = 0, $userID = NULL)
    { 
        if($profile === TRUE)
        {     
            $User = Auth::user();
            $Posts = \App\Post::where('user_id', $User->id)->orderBy('created_at', 'desc')->skip($offset * 10)->take(10)->get();
        }
        elseif($profile === FALSE && $userID === NULL)
        {
            //Get 10 most recent posts by anyone
            $Posts = \App\Post::orderBy('created_at', 'desc')->skip($offset * 10)->take(10)->get();  
        }
        else
        {
            if(!is_numeric($userID))
            {
                try
                {
                    $TargetUser = \App\User::where('username', $userID)->firstOrFail();
                    $TargetUser = $TargetUser->id;
                }
                catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e)
                {
                    abort(404, "OMF");
                }
            }
            else
            {
                $TargetUser = $userID;
            }
              
            $Posts = \App\Post::where('user_id', $TargetUser)->orderBy('created_at', 'desc')->skip($offset * 10)->take(10)->get();  
        }
        
        //Check posts exist
        if(count($Posts) < 1)
        {
            return NULL;
        }

        
        //Set iteration values
        $i = 0;
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        
        
        foreach($Posts as $Post)
        {
            $NiceProfile = $this->MakeNiceUser($Post->User);
            $UserPosts[$i]['Post'] = $Post->getAttributes();
            $UserPosts[$i]['Post']['User'] = $NiceProfile;
            $UserPosts[$i]['Post']['friendly_time'] = $this->generateFriendlyTime($UserPosts[$i]['Post']['created_at']);
            
            $PostEmotions = $Post->Emotions;
            foreach($PostEmotions as $Emotion)
            {
                $UserPosts[$i]['Post']['Emotions'][$d] = $Emotion->getAttributes();
                $UserPosts[$i]['Post']['Emotions'][$d]['Emotion'] = $Emotion->Emotion->getAttributes();
                
                $d++;
            }
            
            $d = 0;
            $PostComments = \App\PostComment::where('post_id', $Post->id)->orderBy('created_at', 'desc')->take(10)->get();
            $totalComments = \App\PostComment::where('post_id', $Post->id)->count();
            
            $PostReactions = \App\PostReaction::where('post_id', $Post->id)->orderBy('created_at', 'desc')->take(10)->get();
            $UserPosts[$i]['Post']['total_reactions'] = \App\PostReaction::where('post_id', $Post->id)->count();

            $UserPosts[$i]['Post']['total_comments'] = $totalComments;
            
            foreach($PostReactions as $Reaction)
            {
                $reactionProfile = $this->MakeNiceUser($Reaction->User);
                $UserPosts[$i]['Post']['Reactions'][$c] = $Reaction->getAttributes();
                $UserPosts[$i]['Post']['Reactions'][$c]['User'] = $reactionProfile;
                $UserPosts[$i]['Post']['Reactions'][$c]['Emotion'] = $Reaction->Emotion->getAttributes();
                
                $c++;
            }
            
            foreach($PostComments as $Comment)
            {
                $commentProfile = $this->MakeNiceUser($Comment->User);
                
                $UserPosts[$i]['Post']['Comments'][$a] = $Comment->getAttributes();
                $UserPosts[$i]['Post']['Comments'][$a]['User'] = $commentProfile;
                $UserPosts[$i]['Post']['Comments'][$a]['friendly_time'] = $this->generateFriendlyTime($UserPosts[$i]['Post']['Comments'][$a]['created_at']);
                
                $totalReplies = \App\PostCommentReply::where('comment_id', $Comment->id)->count();
                $CommentReplies = \App\PostCommentReply::where('comment_id', $Comment->id)->orderBy('created_at', 'desc')->take(10)->get();
                
                $UserPosts[$i]['Post']['Comments'][$a]['total_replies'] = $totalReplies;
                
                foreach($CommentReplies as $Reply)
                {
                    $replyProfile = $this->MakeNiceUser($Reply->User);

                    $UserPosts[$i]['Post']['Comments'][$a]['Replies'][$b] = $Reply->getAttributes();
                    $UserPosts[$i]['Post']['Comments'][$a]['Replies'][$b]['User'] = $replyProfile;
                    
                    $UserPosts[$i]['Post']['Comments'][$a]['Replies'][$b]['friendly_time'] = $this->generateFriendlyTime($UserPosts[$i]['Post']['Comments'][$a]['Replies'][$b]['created_at']);

                    
                    $b++;
                }
                
                $a++;
                $b = 0;
                $c = 0;
                
            }
            
            $a = 0;
            $i++;
        }
        

         return $UserPosts;
    }
    
    private function MakeNiceUser($User)
    {
        
        $niceProfile = [
            'FirstName'     =>  $User->Profile->FirstName->name,
            'LastName'      =>  $User->Profile->LastName->name,
            'Picture'       =>  $User->Profile->picture,
            'Username'      =>  $User->username,
        ];
        
        return $niceProfile;
    }
        
	private function generateFriendlyTime($time)
	{
		$currentTime= new \Datetime();
        $postTime = new \DateTime($time);
        $difference = $postTime->diff($currentTime, TRUE);
        
        if($difference->y > 1)
        {
            return "over " . $difference->y . " years ago";
        }
        elseif($difference->y == 1 || $difference->m == 12)
        {
            return "over a year ago";
        }
        elseif($difference->m < 12 && $difference->m > 1)
        {
            return $difference->m . " months ago";
        }
        elseif($difference->m == 1)
        {
            return $difference->m . " month ago";
        }
        elseif($difference->d < 31 && $difference->d > 1)
        {
            return $difference->d . " days ago";
        }
        elseif($difference->d == 1)
        {
            return $difference->d . " day ago";
        }
        elseif($difference->h < 24 && $difference->h > 1)
        {
            return $difference->h . " hours ago";
        }
        elseif($difference->h == 1)
        {
            return $difference->h . " hour ago";
        }
        elseif($difference->i < 60 && $difference->i > 1)
        {
            return $difference->i . " minutes ago";
        }
        elseif($difference->i == 1)
        {
            return $difference->i . " minute ago";
        }
        elseif($difference->s < 60)
        {
            return "less than a minute";
        }
        
    }
    
}
