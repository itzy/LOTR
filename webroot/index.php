<?php
ob_start();
session_start();
date_default_timezone_set('Europe/Stockholm');
require __DIR__ . '/config_with_app.php';

$app->session;

$app->theme->configure(ANAX_APP_PATH . 'config/theme_me.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_me.php');

// Get the class CFlash
$di->setShared('flash', function () {
    $flash = new Anax\Flash\CFlash();
    return $flash;
});
// Add stylesheet for flash by itzy
$app->theme->addStylesheet('css/flash.css');

$app->router->add('', function () use ($app) {
    $app->theme->setTitle("All about LOTR");

    $content = $app->fileContent->get('index.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $app->views->add('me/index', [
        'content' => $content,
    ]);

});
/*

$app->router->add('logout', function() use ($app)
{
    $app->theme->setTitle("Logout");

    $app->flash->add('info', 'You are now logged out, come back soon!');

    $app->theme->setVariable('title', "Flash")
        ->setVariable('main', $app->flash->get('icons'));

    $content = $app->fileContent->get('logout.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

    $byline = $app->fileContent->get('byline.md');
    $byline = $app->textFilter->doFilter($byline, 'shortcode, markdown');
    $app->views->add('me/page', [
        'content' => $content,
        'byline' => $byline,
        ]);
});
*/

$app->router->add('question/list', function () use ($app) {
    $app->dispatcher->forward([
        'controller' => 'questions',
        'action' => 'list-all',
        'params' => [],
    ]);

    $app->theme->setTitle("Questions");

});

$app->router->add('question/answer', function () use ($app) {
    if (isset($_POST['title'])) {
        $app->dispatcher->forward([
            'controller' => 'questions',
            'action' => 'add',
            'params' => [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'acronym' => $_POST['acronym']],
        ]);
        $app->theme->setTitle("Add answer");


    } else {
        $app->theme->setTitle("Add answer");

        $app->views->add('question/answer', [

        ]);
    }
});

$app->router->add('question/add', function () use ($app) {


    if (isset($_POST['title'])) {
        $app->dispatcher->forward([
            'controller' => 'questions',
            'action' => 'add',
            'params' => [
                'title' => $_POST['title'],
                'content' => $_POST['content'],
                'acronym' => $_POST['acronym']],
        ]);
        $app->theme->setTitle("New question");


    } else {
        $app->theme->setTitle("New question");


        $app->dispatcher->forward([
                'controller' => 'questions',
                'action' => 'viewAdd',
                'params' => []
            ]
        );

        /*
                $content = $app->fileContent->get('add.md');
                $content = $app->textFilter->doFilter($content, 'shortcode, markdown');

                $tags = new \Anax\Question\Projectquestion();

                dd('test');
                $tags = $tags->findAllTags();
                dd($tags);


                $app->views->add('question/add', [
                    'tags' => $tags
                ]);*/
    }

});


$app->router->add('tags', function () use ($app) {
    $app->theme->setTitle("Tags");

    $content = $app->fileContent->get('tags.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');


    $app->views->add('me/page', [
        'content' => $content,
    ]);
});


$app->router->add('about', function () use ($app) {
    $app->theme->setTitle("About");

    $content = $app->fileContent->get('about.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');


    $app->views->add('me/page', [
        'content' => $content,
    ]);
});


$app->router->add('search', function () use ($app) {
    $app->theme->setTitle("Search");
    $content = $app->fileContent->get('search.php');

    $app->views->add('me/page', [
        'content' => $content
    ]);
});

$app->router->add('users', function () use ($app) {
    $app->theme->setTitle("Users");

    $content = $app->fileContent->get('users.md');
    $content = $app->textFilter->doFilter($content, 'shortcode, markdown');


    $app->views->add('me/page', [
        'content' => $content,
    ]);
});

$app->router->add('users/login', function () use ($app) {

    if (isset($_POST['acronym'])) {
        $app->dispatcher->forward([
            'controller' => 'users',
            'action' => 'login',
            'params' => [
                'acronym' => $_POST['acronym'],
                'password' => $_POST['password']],
        ]);
        $app->theme->setTitle("Login");


    } else {
        $app->theme->setTitle("Login");

        $app->views->add('users/login', [

        ]);
    }

});

$app->router->add('users/edit', function () use ($app) {
    if (isset($_POST['name'])) {
        $app->dispatcher->forward([
            'controller' => 'users',
            'action' => 'update',
            'params' => [
                'acronym' => $_POST['acronym'],
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'birthday' => $_POST['birthday']],
        ]);
        $app->theme->setTitle("Edit profile");


    }

});
$app->router->add('users/add', function () use ($app) {
    if (isset($_SESSION['logged_in'])) {
        if ($_SESSION['logged_in']) {
            $app->flash->add('error', 'You can not create user when you are logged in.');
            $app->theme->setVariable('title', "Flash")
                ->setVariable('main', $app->flash->get('icons'));
        } else {
            if (isset($_POST['name'])) {
                $app->dispatcher->forward([
                    'controller' => 'users',
                    'action' => 'add',
                    'params' => [
                        'name' => $_POST['name'],
                        'password' => $_POST['password'],
                        'email' => $_POST['email']],
                ]);
                $app->theme->setTitle("Sign up");


            } else {
                $app->theme->setTitle("Sign up");

                $content = $app->fileContent->get('add.md');
                $content = $app->textFilter->doFilter($content, 'shortcode, markdown');


                $app->views->add('users/add', [

                ]);
            }
        }
    } else {
        if (isset($_POST['name'])) {
            $app->dispatcher->forward([
                'controller' => 'users',
                'action' => 'add',
                'params' => [
                    'name' => $_POST['name'],
                    'password' => $_POST['password'],
                    'email' => $_POST['email']],
            ]);
            $app->theme->setTitle("Sign up");


        } else {
            $app->theme->setTitle("Sign up");

            $content = $app->fileContent->get('add.md');
            $content = $app->textFilter->doFilter($content, 'shortcode, markdown');


            $app->views->add('users/add', [

            ]);
        }
    }

});

$app->router->add('users/list', function () use ($app) {
    $app->dispatcher->forward([
        'controller' => 'users',
        'action' => 'list',
        'params' => [],
    ]);

    $app->theme->setTitle("Users");

});

$app->router->add('tag/list', function () use ($app) {
    $app->dispatcher->forward([
        'controller' => 'questions',
        'action' => 'listAllTags',
        'params' => [],
    ]);

    $app->theme->setTitle("Questions");

});

$app->router->add('source', function () use ($app) {

    $app->theme->addStylesheet('css/source.css');
    $app->theme->setTitle("Source");

    $source = new \Jusi\Source\CSource([
        'secure_dir' => '..',
        'base_dir' => '..',
        'add_ignore' => ['.htaccess'],
    ]);

    $app->views->add('me/source', [
        'content' => $source->View(),
    ]);

});


$app->router->handle();
$app->theme->render();