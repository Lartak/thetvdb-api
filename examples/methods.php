<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 23:48
 */
return [
		'Authentication' => [
			'login' => [
				'apiKey'    =>  ['required' => true, 'type' => 'text', 'label' => 'Client Id'],
				'userKey'    =>  ['required' => true, 'type' => 'text', 'label' => 'Client Secret'],
				'username'    =>  ['required' => true, 'type' => 'text', 'label' => 'Username']
			],
			'refresh_token' => null
		],
		'Episodes' => [
			'episode'   =>  [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the episode']
			]
		],
		'Languages' => [
			'languages' => null,
			'language' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the language']
			]
		],
		'Search' => [
			'series' => [
				'name' => ['type' => 'text', 'required' => false, 'label' => 'Name of the series to search for.'],
				'imdbId' => ['type' => 'text', 'required' => false, 'label' => 'IMDB id of the series'],
				'zap2itId' => ['type' => 'text', 'required' => false, 'label' => 'Zap2it ID of the series to search for.'],
				'slug' => ['type' => 'text', 'required' => false, 'label' => 'Slug from site URL of series (https://www.thetvdb.com/series/$SLUG)']
			],
			'series/params' => null
		],
		'Series' => [
			'series/id' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
			],
			'actors' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
			],
			'episodes' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series'],
				'page' => ['type' => 'number', 'required' => false, 'label' => 'Page of results to fetch. Defaults to page 1 if not provided.', 'default' => 1]
			],
			'episodes/query' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series'],
				'absoluteNumber' => ['type' => 'number', 'required' => false, 'label' => 'Absolute number of the episode'],
				'airedSeason' => ['type' => 'number', 'required' => false, 'label' => 'Aired season number'],
				'airedEpisode' => ['type' => 'number', 'required' => false, 'label' => 'Aired episode number'],
				'dvdSeason' => ['type' => 'number', 'required' => false, 'label' => 'DVD season number'],
				'dvdEpisode' => ['type' => 'number', 'required' => false, 'label' => 'DVD episode number'],
				'imdbId' => ['type' => 'number', 'required' => false, 'label' => 'IMDB id of the series'],
				'page' => ['type' => 'number', 'required' => false, 'label' => 'Page of results to fetch. Defaults to page 1 if not provided.', 'default' => 1],
			],
			'episodes/query/params' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
			],
			'episodes/summary' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
			],
			'filter' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series'],
				'keys' => ['type' => 'text', 'required' => true, 'label' => 'Comma-separated list of keys to filter by']
			],
			'filter/params' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
			],
			'images' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
			],
			'images/query' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series'],
				'keyType' => ['type' => 'text', 'required' => false, 'label' => 'Type of image you\'re querying for (fanart, poster, etc. See images/query/params for more details).'],
				'resolution' => ['type' => 'text', 'required' => false, 'label' => 'Resolution to filter by (1280x1024, for example)'],
				'subKey' => ['type' => 'text', 'required' => false, 'label' => 'Subkey for the above query keys. See images/query/params for more information']
			],
			'images/query/params' => [
				'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
			]
		],
	'Updates' => [
		'query' => [
			'fromTime' => ['type' => 'text', 'required' => true, 'label' => 'Epoch time to start your date range.'],
			'toTime' => ['type' => 'text', 'required' => false, 'label' => 'Epoch time to end your date range. Must be one week from fromTime.'],
		],
		'params' => null
	],
	'User' => [
		'infos' => null,
		'favorites' => null,
		'favorites/list' => null,
		'put_favorite' => [
			'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
		],
		'delete_favorite' => [
			'id' => ['type' => 'number', 'required' => true, 'label' => 'ID of the series']
		],
		'ratings' => null,
		'ratings/query' => [
			'itemType' => ['type' => 'text', 'required' => true, 'label' => 'Item to query. Can be either \'series\', \'episode\', or \'banner\'']
		],
		'ratings/query/params' => null,
		'put_rating' => [
			'itemType' => ['type' => 'text', 'required' => true, 'label' => 'Item to update. Can be either \'series\', \'episode\', or \'image\''],
			'itemId' => ['type' => 'number', 'required' => true, 'label' => 'ID of the ratings record that you wish to modify'],
			'itemRating' => ['type' => 'number', 'required' => true, 'label' => 'The updated rating number']
		],
		'delete_rating' => [
			'itemType' => ['type' => 'text', 'required' => true, 'label' => 'Item to update. Can be either \'series\', \'episode\', or \'image\''],
			'itemId' => ['type' => 'number', 'required' => true, 'label' => 'ID of the ratings record that you wish to modify']
		]
	]
];