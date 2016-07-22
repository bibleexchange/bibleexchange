<?php namespace BibleExperience\GraphQL\Query;

    use Auth, GraphQL;
    use GraphQL\Type\Definition\Type;
    use BibleExperience\GraphQL\Support\Query;    
    use BibleExperience\Notification;
	use BibleExperience\User;

    class NotificationsQuery extends Query {

        protected $attributes = [
            'name' => 'Notifications query'
        ];

        public function type()
        {
            return Type::listOf(GraphQL::type('notification'));
        }

        public function args()
        {
            return [
                'id' => ['name' => 'id', 'type' => Type::string()],
                'filter' => ['name' => 'filter', 'type' => Type::string()]
            ];
        }

        public function resolve($root, $args)
        {

            if(isset($args['id']))
            {
				//localhost/graphql?query=query+FetchUsers{notifications(id:"1"){body}}
                return Notification::where('id' , $args['id'])->get();
            }
            else if(isset($args['filter']))
            {
				//localhost/graphql?query=query+FetchNotifications{users(email:"mjamesderocher@gmail.com"){id,email}}
				
				if(Auth::check()){
					$user = Auth::user();
				}else{
					$user = new User;
				}
				
				$notifications_all = new \BibleExperience\NotificationFetcher($user);
		
				$notifications = $notifications_all->onlyUnread()->fetch();
	
                return $notifications;
            }
            else
            {
                return new Notification;
            }
        }

    }