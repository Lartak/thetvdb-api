<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 07/01/2019
 * Time: 05:54
 */
require '../vendor/autoload.php';
require '../examples/credentials.php';
if (session_status() === PHP_SESSION_NONE) {
	session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST'):
	if (strlen($_POST['language'])) {
		$_SESSION['language'] = $_POST['language'];
	}
endif;
if (!array_key_exists('auth', $_SESSION)) {
	$objectHydrater = new \TheTvDb\Common\ObjectHydrater();
	/** @var \TheTvDb\Auth $auth */
	$auth = $objectHydrater->hydrate(new \TheTvDb\Auth(), ['api_key' => CLIENT_ID, 'user_key' => CLIENT_SECRET, 'username' => USERNAME]);
	try {
		$_SESSION['auth'] = $auth->toArray();
	} catch (\TheTvDb\Exception\NotAuthorizedException $e) {
		throw new \TheTvDb\Exception\ApiException(\TheTvDb\Exception\ApiException::STATUS_NOT_AUTHORIZED, $e->getMessage());
	}
}
$config = ['language' => 'fr'];
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
$repository = new \TheTvDb\Repository\LanguageRepository($client);
$languages = (new \TheTvDb\Repository\LanguageRepository($client))->languages();
$page = array_key_exists('page', $_GET) ? (int)$_GET['page'] : 1;
$parameters['page'] = $page;
$parameters['includes'] = ['episodes'];
/** @var \TheTvDb\Model\Series $show */
$show = (new \TheTvDb\Repository\SeriesRepository($client))->load((int)$_GET['id'], $parameters);
$helper = new \TheTvDb\Helper\Helper();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?= $show->getSeriesName() ?></title>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.6.0/css/mdb.min.css" rel="stylesheet">
        <style>
            html,
            body,
            header,
            .view.fiche {
                height: 85%;
            }

            @media (max-width: 740px) {
                html,
                body,
                header,
                .view.fiche {
                    height: 1000px;
                }
            }

            @media (min-width: 800px) and (max-width: 850px) {
                html,
                body,
                header,
                .view.fiche {
                    height: 530px;
                }
            }

            .view.fiche {
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center center;
            }

            .btn .fa {
                margin-left: 3px;
            }

            .top-nav-collapse {
                background-color: #424f95 !important;
            }

            .navbar:not(.top-nav-collapse) {
                background: transparent !important;
            }

            @media (max-width: 991px) {
                .navbar:not(.top-nav-collapse) {
                    background: #424f95 !important;
                }
            }

            h6 {
                line-height: 1.7;
            }

            .rgba-gradient {
                background: -moz-linear-gradient(45deg, rgba(42, 27, 161, 0.7), rgba(29, 210, 177, 0.7) 100%);
                background: -webkit-linear-gradient(45deg, rgba(42, 27, 161, 0.7), rgba(29, 210, 177, 0.7) 100%);
                background: -webkit-gradient(linear, 45deg, from(rgba(42, 27, 161, 0.7)), to(rgba(29, 210, 177, 0.7)));
                background: -o-linear-gradient(45deg, rgba(42, 27, 161, 0.7), rgba(29, 210, 177, 0.7) 100%);
                background: linear-gradient(to 45deg, rgba(42, 27, 161, 0.7), rgba(29, 210, 177, 0.7) 100%);
            }
        </style>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark fixed-top scrolling-navbar">
                <div class="container">
                    <a class="navbar-brand" href="/">The TVDB API Test</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
                            aria-controls="basicExampleNav"
                            aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </nav>
            <div class="view fiche" style="background-image: url(<?= $helper->imageHelper()->url($show) ?>);">
                <div class="mask rgba-gradient d-flex justify-content-center align-items-center">
                    <div class="container-fluid">
                        <div class="row">
                            <?php $voteAverage = $show->getSite()->getRating(); ?>
                            <div class="col-5 white-text text-center text-md-left mb-5 wow fadeInLeft" data-wow-delay="0.3s">
                                <h1 class="h1-responsive font-weight-bold mt-sm-5 white-text text-uppercase"><?= $show->getSeriesName() ?></h1>
                                <h2 class="h2-responsive white-text">First Aired
                                    : <?= $show->getFirstAired()->format('Y-m-d') ?></h2>
                                <h3 class="h3-responsive white-text">Network : <?= $show->getNetwork()->getName() ?></h3>
                                <?php if (strlen($show->getRating())): ?>
                                    <h4 class="h4-responsive white-text">Rating : <?= $show->getRating() ?></h4>
                                <?php endif; ?>
                                <p>Genres : <?= implode(', ', $show->getGenre()) ?></p>
                                <p>Status : <?= $show->getStatus() ?></p>
                                <p><a href="<?= sprintf('/serie.php?id=%s', $show->getId()) ?>" class="btn btn-secondary"><i class="fa fa-arrow-left"></i></a></p>
                            </div>
                            <div class="col-7 col-xl-5 mt-xl-5 wow fadeInRight" data-wow-delay="1s">
                                <p class="lead text-white"><?= $show->getOverview() ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills nav-fill">
                        <?php foreach ($languages as $language): /** @var \TheTvDb\Model\Language $language */ ?>
                            <li class="nav-item">
                                <form action="" method="post">
                                    <input name="language" type="text" value="<?= $language->getAbbreviation() ?>"
                                           style="display: none;">
                                    <button type="submit"
                                            class="btn btn-sm <?= (array_key_exists('language', $_SESSION) && $_SESSION['language'] === $language->getAbbreviation()) ? 'btn-primary' : 'btn-default' ?>"
                                            data-toggle="tooltip"
                                            title="<?= $language->getEnglishName() ?>"><?= $language->getName() ?></button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="row">
                <section class="col-6"></section>
                <section class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-right">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination pagination-circle pg-blue">
                                        <li class="page-item<?= $show->getEpisodes()->getPrev() >= 1 ? '' : ' disabled' ?>">
                                            <a class="page-link" href="<?= sprintf('/episodes.php?id=%d', $show->getId()) ?>">First</a>
                                        </li>
                                        <li class="page-item<?= $show->getEpisodes()->getPrev() >= 1 ? '' : ' disabled' ?>">
                                            <a class="page-link" aria-label="Previous"
                                               href="<?= sprintf('/episodes.php?id=%d%s', $show->getId(), $show->getEpisodes()->getPrev() > 1 ? '&page=' . $show->getEpisodes()->getPrev() : '') ?>">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <li class="page-item<?= $show->getEpisodes()->getNext() != 0 ? '' : ' disabled' ?>">
                                            <a class="page-link" aria-label="Next"
                                               href="<?= sprintf('/episodes.php?id=%d&page=%d', $show->getId(), $show->getEpisodes()->getNext()) ?>">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                        <li class="page-item<?= $show->getEpisodes()->getNext() != 0 ? '' : ' disabled' ?>">
                                            <a class="page-link"
                                               href="<?= sprintf('/episodes.php?id=%d&page=%d', $show->getId(), $show->getEpisodes()->getLast()) ?>">Last</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <h3 class="h3-responsive">Episodes</h3>
                        </div>
                    </div>
                    <div class="row">
                        <?php foreach ($show->getEpisodes() as $episode): /** @var \TheTvDb\Model\Episode $episode */ ?>
                            <div class="col-6 mb-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <?= $helper->imageHelper()->html($episode, ['class' => 'img-fluid']) ?>
                                                <dl class="row">
                                                    <dt class="col-6">Season</dt>
                                                    <dd class="col-6"><?= $episode->getAired()->getSeason()->getNumber() ?></dd>
                                                    <dt class="col-6">Episode</dt>
                                                    <dd class="col-6"><?= $episode->getAired()->getEpisodeNumber() ?></dd>
                                                    <?php if ($episode->getAired()->getSeason()->getNumber() !== 1): ?>
                                                        <dt class="col-6">Global</dt>
                                                        <dd class="col-6"><?= $episode->getAbsoluteNumber() ?></dd>
                                                    <?php endif; ?>
                                                    <dt class="col-4">Date</dt>
                                                    <dd class="col-8"><?= $episode->getFirstAired() ?></dd>
                                                </dl>
                                            </div>
                                            <div class="col-6">
                                                <?= $episode->getName() ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </main>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript"
                src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.6.0/js/mdb.min.js"></script>
        <script type="text/javascript">
            new WOW().init();
        </script>
    </body>
</html>