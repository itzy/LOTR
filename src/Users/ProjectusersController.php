<?php

namespace Anax\Users;
use Anax\Session\CSession;

/**
 * A controller for users and admin related events.
 *
 */
class ProjectusersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;


    /**
     * Initialize the controller.
     *
     * @return void
     */
/*    public function initialize()
    {
        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);
    }
*/
    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);

        $all = $this->users->findAll();

        $this->theme->setTitle("All users");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "All users",
        ]);
    }


    /**
     * List user with id.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function idAction($id = null)
    {
        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);

        if(!isset($id))
        {
            $user = $this->session->get('logged_in');
            $id = $user['id'];

            if(!isset($id))
            {
                die("Missing id.");
            }
        }

        $user = $this->users->find($id);

        $id = $user->id;
        $acronym = $user->acronym;



        $questions = $this->users->findQuestions($id);
        $answers = $this->users->findAnswers($acronym);


        $this->theme->setTitle($user->acronym . "'s profil");
        $this->views->add('users/view', [
            'user' => $user,
            'questions' => $questions,
            'answers' => $answers
        ]);


    }

    public function editAction($id = null)
    {
        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);

        if(!isset($id))
        {
            $user = $this->session->get('logged_in');
            $id = $user['id'];

            if(!isset($id))
            {
                die("Missing id.");
            }
        }

        $user = $this->users->find($id);
        $this->theme->setTitle($user->acronym . "'s profil");
        $this->views->add('users/edit', [
            'user' => $user
        ]);

        if(isset($_POST['update']))
        {
            $this->users->save([
                'acronym' => $_POST['acronym'],
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'birthday' => $_POST['birthday'],
                'content' => $_POST['content'],
                'active' => date('Y-m-d H:i'),
            ]);
        }
    }

    public function addAction($acronym = null)
    {
        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);


if (!isset($acronym)) {
            die("Missing acronym");
        }
        date_default_timezone_set('Europe/Stockholm');

        $this->users->save([
            'acronym' => $_POST['acronym'],
            'name' => $_POST['name'],
            'password' => md5 ($_POST['password']),
            'email' => $_POST['email'],
            'created' => date('Y-m-d H:i'),
            'active' => date('Y-m-d H:i'),
            'birthday' => $_POST['birthday'],
        ]);

        $this->session->set('logged_in', true);

        $userInfo = [
            'id' => $this->users->id,
            'acronym' => $this->users->acronym,
            'email' => $this->users->email,
            'name' => $this->users->name,
            'birthday' => $this->users->birthday,
        ];

        $this->session->set('user_info', $userInfo);

        $this->flash->add('success', 'Welcome as a member!');
        $this->theme->setVariable('title', "Flash")
            ->setVariable('main', $this->flash->get('icons'));
/*        $url = $this->url->create('users/id/' . $this->users->id);
        $this->response->redirect($url);*/


    }

    /**
     * Delete user.
     *
     * @param integer $id of user to delete.
     *
     * @return void
     */
    public function deletecontrolAction($id)
    {
        $this->flash->add('warning', 'Are you sure you want to delete this user?');
        $this->theme->setVariable('title', "Flash")
            ->setVariable('main', $this->flash->get('icons'));

        $this->theme->setTitle('Logga ut');
        $this->views->add('users/delete');


    }

    public function deleteAction($id = null)
    {

        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);

        if (!isset($id)) {
            die("Missing id");
        }

        $res = $this->users->delete($id);

        $this->flash->add('success', 'This user exists no more!');
        $this->theme->setVariable('title', "Flash")
            ->setVariable('main', $this->flash->get('icons'));
        $this->session->set('logged_in', false);
        $this->session->set('user_info', null);
        $this->theme->setTitle('Delete complete');

    }
    public function loginAction()
    {

        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);

        $user = $this->users->findByAcronym($this->request->getPost('acronym'));

    if(!isset($this->users->acronym)) {


            $this->flash->add('error', 'Wrong username or password, try again!');
            $this->theme->setVariable('title', "Flash")
                ->setVariable('main', $this->flash->get('icons'));

        return;
        }

        if($this->users->password == (md5($this->request->getPost('password'))))
        {
            $this->session->set('logged_in', true);
            $user->active = date(DATE_RFC2822);

            $userInfo = [
                'id' => $this->users->id,
                'acronym' => $this->users->acronym,
                'email' => $this->users->email,
                'name' => $this->users->name,
                'birthday' => $this->users->birthday,
                'posts' => $this->users->posts,
            ];

            $this->session->set('user_info', $userInfo);
            $this->session->set('logged_in', true);

            $url = $this->url->create('');

        }

        $this->response->redirect($url);
        exit();

    }


    public function logoutAction()
    {

        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);


        $user = $this->session->get('logged_in');

        $this->session->set('logged_in', false);
        $this->session->set('user_info', null);
        $this->flash->add('info', "You are now logged out, come back soon or we'll miss you ;)");
        $this->theme->setVariable('title', "Flash")
            ->setVariable('main', $this->flash->get('icons'));

        $this->theme->setTitle('Logga ut');

    }

    public function gravatarAction($username)
    {
        if(empty($username))
        {
            die("Missing username.");
        }

        $user = $this->users->findByUsername($username);

        $gravatar = 'http://www.gravatar.com/avatar/' . md5(strtolower(trim($user->email))) . '.jpg?s=60';

        return $user->email;
    }

    function Authenticated()
    {
        if(isset($_SESSION['user'])){
            return true;
        }
        else{
            return false;
        }
    }

    function output()
    {
        $acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;
        if($acronym) {
            $output = "Du är inloggad som: $acronym ({$_SESSION['user']->name})";
        }
        else {
            $output = "Du är INTE inloggad.";
        }
        return $output;
    }

    function loginViewAction() {

        $this->theme->setTitle('test');
        $this->views->add('users/login');
        return;

    }

    public function acronymAction($acronym = null)
    {
        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);

        if(!isset($acronym))
        {
            die("Missing username.");
        }

        $user = $this->users->findByAcronym($acronym);
        $acronym = $user->acronym;

        $id = $user->id;
        $answers = $this->users->findAnswers($acronym);
        $questions = $this->users->findQuestions($id);

        $this->theme->setTitle($user->acronym . "'s profil");
        $this->views->add('users/view', [
            'user' => $user,
            'questions' => $questions,
            'answers' => $answers
        ]);

    }

/*    public function MostactiveuserAction()
    {
        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);

        $user =
    }
*/
}

