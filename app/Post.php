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
	
	public function StreamData($offset, $userID = null)
	{
				
		if($userID != null)
		{
			$posts = \DB::table('posts')
						->select("id", "created_at", \DB::raw("'post' as source")
						->where("user_id", $userID));
							
			$posts_cbt = \DB::table('cbt')
						->select("id", "created_at", \DB::raw("'cbt' as source"))
						->where("user_id", $userID)
						->union($posts)
						->orderBy('created_at', 'desc')
						->skip($offset * 10)
						->limit(10)
						->get();
		}	
					
		else
		{
			$posts = \DB::table('posts')
						->select("id", "created_at", \DB::raw("'post' as source"));
							
			$posts_cbt = \DB::table('cbt')
						->select("id", "created_at", \DB::raw("'cbt' as source"))
						->union($posts)
						->orderBy('created_at', 'desc')
						->skip($offset * 10)
						->limit(10)
						->get();
		}
			
		foreach($posts_cbt as $item)
		{
			switch($item->source)
			{
				case "post":
					$model = "\App\\Post";
					break;
					
				case "cbt":
					$model = "\App\\CBT";
					break;
			}
			
			$items[] = $model::where('id', $item->id)->first();
		}
		
		return $items;
	}
    
    public function Stream($profile = FALSE, $offset = 0, $userID = NULL)
    { 
        if($profile === TRUE)
        {     
            $User = Auth::user();
            $Posts = $this->StreamData($offset, $User->id);

        }
        elseif($profile === FALSE && $userID === NULL)
        {
            //Get 10 most recent posts by anyone
			$Posts = $this->StreamData($offset);
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
              
            $Posts = $this->StreamData($offset, $TargetUser);  
        }
        
        //Check posts exist
        if(count($Posts) < 1)
        {
            return NULL;
        }

        foreach($Posts as $Post)
        {
			if(get_class($Post) == "App\\Post")
			{
				$NiceProfile = $this->MakeNiceUser($Post->User);
								
				$PostEmotions = $Post->Emotions;
				foreach($PostEmotions as $Emotion)
				{
					$Emotions[] = $Emotion->getAttributes();
					$key = key($Emotions);
					$Emotions[$key]['Emotion'] = $Emotion->Emotion->getAttributes();
					next($Emotions);					
				}
				
				$PostComments = \App\PostComment::where('post_id', $Post->id)->orderBy('created_at', 'desc')->take(10)->get();
				$totalComments = \App\PostComment::where('post_id', $Post->id)->count();
				
				$PostReactions = \App\PostReaction::where('post_id', $Post->id)->orderBy('created_at', 'desc')->take(10)->get();
				$totalReactions = \App\PostReaction::where('post_id', $Post->id)->count();
				
				foreach($PostReactions as $Reaction)
				{
					$Reactions[$Reaction->Emotion->emotion][] = $Reaction->getAttributes();
					$key = key($Reactions[$Reaction->Emotion->emotion]);
					$Reactions[$Reaction->Emotion->emotion][$key]['User'] = $this->MakeNiceUser($Reaction->User);
					$Reactions[$Reaction->Emotion->emotion][$key]['Emotion'] = $Reaction->Emotion->getAttributes();
					next($Reactions[$Reaction->Emotion->emotion]);
				}
				
				if(!isset($Reactions))
				{
					$Reactions = NULL;
				}
				
				foreach($PostComments as $Comment)
				{
					$commentProfile = $this->MakeNiceUser($Comment->User);
					$totalReplies = \App\PostCommentReply::where('comment_id', $Comment->id)->count();
					$CommentReplies = \App\PostCommentReply::where('comment_id', $Comment->id)->orderBy('created_at', 'desc')->take(10)->get();
					
					foreach($CommentReplies as $Reply)
					{
						$replyProfile = $this->MakeNiceUser($Reply->User);
						
						$Replies[] = $Reply->getAttributes();
						$key = key($Replies);
						$Replies[$key]['friendly_time'] = $this->generateFriendlyTime($Reply->created_at->format('Y-m-d H:i:s'));
						$Replies[$key]['User'] = $replyProfile;
						next($Replies);
					}
					
					if(!isset($Replies))
					{
						$Replies = NULL;
					}
					
					$Comments[] = $Comment->getAttributes();
					$key = key($Comments);
					$Comments[$key]['friendly_time'] = $this->generateFriendlyTime($Comment->created_at->format('Y-m-d H:i:s'));
					$Comments[$key]['total_replies'] = $totalReplies;
					$Comments[$key]['User'] = $commentProfile;
					$Comments[$key]['Replies'] = $Replies;
					next($Comments);
					
					$Replies = NULL;
				}
				
				if(!isset($Comments))
				{
					$Comments = NULL;
				}
	
				$UserPosts[]['Post'] = $Post->getAttributes();
				$key = key($UserPosts);
				$UserPosts[$key]['Post']['User'] = $NiceProfile;
				$UserPosts[$key]['Post']['friendly_time'] = $this->generateFriendlyTime($Post->created_at->format('Y-m-d H:i:s'));
				$UserPosts[$key]['Post']['Emotions'] = $Emotions;
				$UserPosts[$key]['Post']['total_reactions'] = $totalReactions;
				$UserPosts[$key]['Post']['total_comments'] = $totalComments;
				$UserPosts[$key]['Post']['Reactions'] = $Reactions;
				$UserPosts[$key]['Post']['Comments'] = $Comments;
				next($UserPosts);
			
				$Emotions = NULL;
				$Comments = NULL;
				$Reactions = NULL;

			}
			else
			{
				$NiceProfile = $this->MakeNiceUser($Post->User);
			}
		}
         return $UserPosts;
    }
    
    private function MakeNiceUser($User)
    {
        $niceProfile = [
            'id'            =>  $User->id,
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
