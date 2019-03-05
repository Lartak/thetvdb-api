<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 02:21
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__DIR__) . DS);
require ROOT_DIR . 'vendor' . DS . 'autoload.php';
require ROOT_DIR . 'examples' . DS . 'credentials.php';
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
if (!array_key_exists('auth', $_SESSION)) {
	$objectHydrater = new \TheTvDb\Common\ObjectHydrater();
	/** @var \TheTvDb\Auth $auth */
	$auth = $objectHydrater->hydrate(new \TheTvDb\Auth(), [
		'apiKey'   =>  CLIENT_ID,
		'userKey'  =>  CLIENT_SECRET,
		'username'  =>  USERNAME
	]);
	try {
		$_SESSION['auth'] = $auth->toArray();
	} catch (\TheTvDb\Exception\NotAuthorizedException $e) {
		throw new \TheTvDb\Exception\ApiException(\TheTvDb\Exception\ApiException::STATUS_NOT_AUTHORIZED, $e->getMessage());
	}
}
$config = [
    'cache' => [
        'enabled' => true,
        'path'  =>  ROOT_DIR . 'tmp' . DIRECTORY_SEPARATOR . 'cache'
    ]/*,
    'log'   =>  [
        'enabled'   =>  true,
        'path'      =>  ROOT_DIR . 'tmp' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'dev.log'
    ],
    'language' => 'fr'*/
];
if (array_key_exists('language', $_SESSION)) {
    $config['language'] = $_SESSION['language'];
}
if (array_key_exists('token', $_SESSION)) {
	/** @var \TheTvDb\Token $token */
	$token = $_SESSION['token'];
} else {
	$token = null;
}
$client = new \TheTvDb\Client($token, $config);
if (!is_null($token) && !$token->isExpired()):
    $languages = (new \TheTvDb\Repository\LanguageRepository($client))->languages();
endif;
$methods = include ROOT_DIR . 'examples' . DS .'methods.php';
class ForDemo {
	private $data;
	/**
     * getValue Method
	 * @var string
	 */
	private $getValue;
	/**
	 * ForDemo constructor.
	 *
	 * @param \TheTvDb\Model\Common\CollectionToCommaSeparatedString $data
	 */
	public function __construct($data)
	{
		$this->data = $data;
		$this->getValue = $data->getValue();
	}
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    $methodGet = $_GET['method'];
	if ($_GET['method'] === 'login'):
		$objectHydrater = new \TheTvDb\Common\ObjectHydrater();
		/** @var \TheTvDb\Auth $auth */
		$auth = $objectHydrater->hydrate(new \TheTvDb\Auth(), [
			'apiKey'   =>  $_POST['apiKey'],
			'userKey'  =>  $_POST['userKey'],
			'username'  =>  $_POST['username']
		]);
		$object = $auth;
		$array = $auth->toArray();
		$repository = new \TheTvDb\Repository\AuthenticationRepository($client);
		$token = $repository->login($auth);
		$_SESSION['token'] = $token;
	else:
        switch ($_GET['section']):
            case 'Authentication':
                if ($methodGet === 'refresh_token'):
                    $api = $client->getAuthenticationApi();
                    $array = $api->refreshToken();
                    $token = new \TheTvDb\Token($array['token']);
                    $token->setSuccess(true);
	                try {
		                $token->setCreatedAt(new \DateTime());
		                $_SESSION['token'] = $token;
		                $object = $token;
	                } catch (Exception $e) {
	                    throw new \TheTvDb\Exception\NotAuthorizedException(\TheTvDb\Exception\ApiException::STATUS_NOT_AUTHORIZED, $e->getMessage());
	                }
                endif;
                break;
            case 'Episodes':
                $api = $client->getEpisodeApi();
                $array = $api->load($_POST['id']);
                $object = (new \TheTvDb\Factory\EpisodeFactory($client->getHttpClient()))->create($array);
                break;
            case 'Languages':
                $api = $client->getLanguageApi();
                $factory = new \TheTvDb\Factory\LanguageFactory($client->getHttpClient());
                switch ($methodGet):
                    case 'languages':
                        $array = $api->getLanguages();
                        $object = $factory->createCollection($array);
                        break;
                    case 'language':
                        $id = (int)$_POST['id'];
	                    $array = $api->getLanguage($id);
	                    $object = $factory->create($array);
                        break;
                    case 'preference':
                        if (strlen($_POST['language'])) {
                            $_SESSION['language'] = $_POST['language'];
	                        header("Location: /");
                        }
                        break;
                endswitch;
                break;
            case 'Search':
                $api = $client->getSearchApi();
                $repository = new \TheTvDb\Repository\SearchRepository($client);
                switch ($methodGet):
                    case 'series':
                        $index = null;
                        $val = null;
                        foreach ($_POST as $key => $value)
                        {
                            if (!empty($value)) {
                                $index = $key;
                                $val = $value;
                            }
                        }
                        $array = $api->getSeries([$index => $val]);
                        $object = $repository->series($index, $val);
                        if ($object instanceof \TheTvDb\Model\Series\Search)
                        {
                            /** @var \TheTvDb\Model\Series\Search $object */
                            header("Location: /serie.php?id={$object->getId()}");
                        }
                        break;
                    case 'series/params':
                        $array = $api->getSeriesParams();
                        $object = new ForDemo($repository->seriesParams());
                        break;
                endswitch;
                break;
            case 'Series':
                $api = $client->getSeriesApi();
                $repository = new \TheTvDb\Repository\SeriesRepository($client);
	            $id = (int)$_POST['id'];
                switch ($methodGet):
                    case 'actors':
                        $array = $api->getActors($id);
                        $object = $repository->getActors($id);
                        break;
                    case 'series/id':
	                    header("Location: /serie.php?id=$id");
                        $array = $api->load($id);
                        $object = $repository->load($id, ['includes' => ['actors', 'episodes', 'images']]);
                        break;
                    case 'episodes':
                        $page = (int)$_POST['page'];
                        $array = $api->getEpisodes($id, $page);
                        $object = $repository->getEpisodes($id, $page);
                        break;
                    case 'episodes/query':
                        $page = (int)$_POST['page'];
	                    $index = null;
	                    $val = null;
	                    $parameters = [];
	                    if (strlen($_POST['absoluteNumber'])) {
		                    $absoluteNumber = $_POST['absoluteNumber'];
		                    $array = $api->getEpisodesQuery($id, ['page' => 1, 'absoluteNumber' => $absoluteNumber]);
		                    $object = $repository->findEpisodeByAbsoluteNumber($id, $absoluteNumber);
	                    } elseif (strlen($_POST['airedSeason'])) {
		                    $airedSeason = $_POST['airedSeason'];
		                    $page = $_POST['page'];
		                    $array = $api->getEpisodesQuery($id, ['page' => 1, 'airedSeason' => $airedSeason]);
		                    $object = $repository->findEpisodesBySeason($id, $airedSeason, $page);
                        } else {
		                    foreach ($_POST as $key => $value)
		                    {
			                    if (strlen($value)) {
				                    $parameters[$key] = in_array($key, ['airedEpisode', 'dvdSeason', 'dvdEpisode']) ? (int)$value : $value;
			                    }
		                    }
		                    unset($parameters['id']);
		                    try {
			                    $array = $api->getEpisodesQuery($id, $parameters);
			                    $object = $repository->getEpisodesQuery($id, $page, $parameters);
		                    } catch (\Exception $e) {
			                    $array = [];
			                    $object = null;
		                    }
                        }
                        break;
                    case 'episodes/query/params':
                        $array = $api->getEpisodesQueryParams($id);
                        $object = new ForDemo($repository->episodesQueryParams($id));
                        break;
                    case 'episodes/summary':
                        $array = $api->getEpisodesSummary($id);
                        /** @var \TheTvDb\Model\Series\Summary $object */
                        $object = $repository->getFactory()->hydrateSummary($repository->getSummary($id));
                        break;
                    case 'filter':
                        $keys = $_POST['keys'];
                        $array = $api->filter($id, $keys);
                        $object = $repository->filter($id, $keys);
                        break;
                    case 'filter/params':
                        $array = $api->filterParams($id);
                        $object = new ForDemo($repository->filterParams($id));
                        break;
                    case 'images':
                        $array = $api->images($id);
                        $object = $repository->getImages($id);
                        break;
                    case 'images/query':
                        $params = [];
                        if (strlen($_POST['keyType'])) {
                            $params['keyType'] = $_POST['keyType'];
                        }
	                    if (strlen($_POST['resolution'])) {
		                    $params['resolution'] = $_POST['resolution'];
	                    }
	                    if (strlen($_POST['subKey'])) {
		                    $params['subKey'] = $_POST['subKey'];
	                    }
	                    try {
		                    $array = $api->getImagesQuery($id, $params);
		                    $object = $repository->getImagesQuery($id, $params);
	                    } catch (\TheTvDb\Exception\ApiException $e) {
	                        $_SESSION['Flash'][] = ['class' => 'danger', 'message' => $e->getMessage()];
	                    }
	                    break;
                    case 'images/query/params':
                        $array = $api->getImagesQueryParams($id);
                        $object = $repository->getImagesQueryParams($id);
                        break;
                endswitch;
                break;
            case 'Updates':
                $api = $client->getUpdatesApi();
                switch ($methodGet):
                    case 'query':
                        $fromTime = $_POST['fromTime'];
                        $toTime = !empty($_POST['toTime']) ? (new \DateTime($_POST['toTime']))->getTimestamp() : null;
                        if (is_string($fromTime)) {
                            $fromTime = (new \DateTime($_POST['fromTime']))->getTimestamp();
                        }
                        $array = $api->query(
                                $fromTime,
                                $toTime
                        );
                        $object = (new \TheTvDb\Repository\UpdateRepository($client))->query($fromTime, $toTime);
                        break;
                    case 'params':
                        $array = $api->queryParams();
                        break;
                endswitch;
                break;
            case 'User':
                $api = $client->getUserApi();
                $repository = (new \TheTvDb\Repository\UserRepository($client));
                switch ($methodGet):
                    case 'infos':
                        $array = $api->load();
                        $object = $repository->infos(['includes' => ['favorites', 'ratings']]);
                        break;
                    case 'favorites':
                        $array = $api->favorites();
                        $object = $repository->favorites();
                        break;
	                case 'favorites/list':
		                $array = $api->favoritesList();
		                $object = new ForDemo($repository->favoritesList());
		                break;
                    case 'put_favorite':
                        $id = $_POST['id'];
                        //$array = $api->addFavorite($id);
                        $object = $repository->addFavorite($id);
                        break;
                    case 'delete_favorite':
	                    $id = $_POST['id'];
                        //$array = $api->removeFavorite($id);
	                    $object = $repository->removeFavorite($id);
                        break;
	                case 'ratings':
		                $array = $api->ratings();
		                $object = $repository->ratings();
		                break;
	                case 'ratings/query':
	                    $itemType = $_POST['itemType'];
		                $array = $api->ratingsQuery($itemType);
		                $object = $repository->ratingsQuery($itemType);
		                break;
	                case 'ratings/query/params':
		                $array = $api->ratingsQueryParams();
		                $object = new ForDemo($repository->ratingsQueryParams());
		                break;
	                case 'put_rating':
	                    $itemId = $_POST['itemId'];
	                    $itemType = $_POST['itemType'];
		                $itemRating = $_POST['itemRating'];
		                $array = $api->updateRating($itemId, $itemType, $itemRating);
		                break;
	                case 'delete_rating':
		                $array = $api->removeFavorite($id);
		                break;
                endswitch;
                break;
        endswitch;
	endif;
endif;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title>Material Design Bootstrap</title>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
		<!-- Bootstrap core CSS -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
		<!-- Material Design Bootstrap -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.6.0/css/mdb.min.css" rel="stylesheet">
		<!-- Your custom styles (optional) -->
	</head>
	<body>
		<!-- Start your project here-->
		<header>
			<nav class="navbar navbar-expand-lg navbar-dark primary-color">
				<a class="navbar-brand" href="/">The TVDB API Test</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav" aria-controls="basicExampleNav"
				        aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="basicExampleNav">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item<?= empty($_GET['section']) ? ' active' : '' ?>">
							<a class="nav-link" href="/">Home
								<span class="sr-only">(current)</span>
							</a>
						</li>
						<?php foreach ($methods as $section => $actions): if ((!is_null($token) && !$token->isExpired()) || $section === 'Authentication'): ?>
						<li class="nav-item dropdown<?= (!empty($_GET['section']) && $_GET['section'] === $section) ? ' active' : '' ?>">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink<?= $section ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $section ?></a>
							<div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink<?= $section ?>">
								<?php foreach ($actions as $action => $fields):
									$parts = explode('/', $action);
									$label = '';
									foreach ($parts as $key => $part):
										$label .= $key !== count($parts) ? ucfirst($part) . ' ' : ucfirst($part);
									endforeach;
									if (preg_match('/[AZaz\_]/', $label)):
										$parts = explode('_', $label);
										$label = '';
										foreach ($parts as $key => $part):
											$label .= $key !== count($parts) ? ucfirst($part) . ' ' : ucfirst($part);
										endforeach;
									endif;
								?>
								<a class="dropdown-item" href="<?= sprintf('/?section=%s&method=%s', $section, $action) ?>"><?= $label ?></a>
								<?php endforeach; ?>
							</div>
						</li>
						<?php endif; endforeach; ?>
					</ul>
					<?php if (!empty($_SESSION['token'])): $token = $_SESSION['token']; ?>
					<form class="form-inline">
						<div class="md-form my-0">
							<input class="form-control mr-sm-2" type="text" placeholder="Votre token" aria-label="Token" value="<?= $token->getToken() ?>">
						</div>
					</form>
					<?php endif; ?>
				</div>
			</nav>
		</header>
		<main class="container-fluid">
            <?php if (!empty($languages)): ?>
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills nav-fill">
		                <?php foreach ($languages as $language): /** @var \TheTvDb\Model\Language $language */ ?>
                            <li class="nav-item">
                                <form action="/?section=Languages&method=preference" method="post">
                                    <input name="language" type="text" value="<?= $language->getAbbreviation() ?>" style="display: none;">
                                    <button type="submit" class="btn btn-sm <?= (array_key_exists('language', $_SESSION) && $_SESSION['language'] === $language->getAbbreviation()) ? 'btn-primary' : 'btn-default' ?>" data-toggle="tooltip" title="<?= $language->getEnglishName() ?>"><?= $language->getName() ?></button>
                                </form>
                            </li>
		                <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; if (array_key_exists('Flash', $_SESSION)): ?>
            <div class="row">
                <div class="col-12">
                    <?php foreach ($_SESSION['Flash'] as $flash): ?>
                        <div class="alert alert-<?= $flash['class'] ?> alert-dismissible fade show" role="alert">
                            <?= $flash['message'] ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endforeach; unset($_SESSION['Flash']); ?>
                </div>
            </div>
            <?php endif; ?>
			<div class="row">
				<section class="col-3">
					<?php if (!empty($_GET['method']) && $_GET['method'] !== 'preference'): $method = str_replace('%2F', '/', $_GET['method']); $section = $_GET['section']; ?>
					<div class="row">
						<div class="col-12">
							<h5><?= sprintf('Form to test method <strong>%s</strong> in section <strong>%s</strong>', $_GET['method'], $_GET['section']) ?></h5>
							<form action="" method="post">
								<?php if (!is_null($methods[$section][$method])): $index = 0; foreach ($methods[$section][$method] as $name => $field):
									if (!empty($_POST[$name])):
										$value = $_POST[$name];
									else:
										$value = array_key_exists('default', $field) ? $field['default'] : '';
									endif;
									?>
								<div class="md-form mb-5">
									<input value="<?= $value ?>" type="<?= $field['type'] ?>" class="form-control" name="<?= $name ?>"<?= $field['required'] ? ' required' : '' ?><?= $index === 0 ? ' autofocus' : '' ?>>
									<label for="<?= $name ?>"><?= $field['label'] ?></label>
								</div>
								<?php endforeach; else: ?>
								<div class="alert alert-info" role="alert">
									No parameter for this method
								</div>
								<?php endif; ?>
								<input type="submit" value="Soumettre la méthode" class="btn btn-outline-primary waves-effect">
							</form>
						</div>
					</div>
					<?php endif; ?>
				</section>
				<section class="col-9">
					<div class="row">
						<?php if (!empty($object)): ?>
						<section class="col-6">
                            <h3>Data via Model</h3>
							<pre class="pre-scrollable" style="max-height: 790px;">
								<?php var_dump($object); ?>
							</pre>
						</section>
						<?php endif; ?>
						<?php if (!empty($array)): ?>
							<section class="col-6">
                                <h3>Data via API</h3>
							<pre class="pre-scrollable" style="max-height: 790px;">
								<?php var_dump($array); ?>
							</pre>
							</section>
						<?php endif; ?>
					</div>
				</section>
			</div>
		</main>
		<!-- /Start your project here-->
		<!-- SCRIPTS -->
		<!-- JQuery -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!-- Bootstrap tooltips -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
		<!-- Bootstrap core JavaScript -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<!-- MDB core JavaScript -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.6.0/js/mdb.min.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				$('[data-toggle="tooltip"]').tooltip();
            });
		</script>
	</body>
</html>