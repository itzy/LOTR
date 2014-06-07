<?php

namespace Anax\Comment;

class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    public function initialize()
    {
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);
    }

    public function addAction()
    {
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);

        if(!$this->request->getPost('addComment'))
        {
            $this->response->redirect($this->request->getPost('doSave'));
        }

        $this->comments->save([
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        ]);

        $this->response->redirect($this->request->getPost('redirect'));
    }


    public function saveChangesAction() {

        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);

            if(!$this->request->getPost('doSave'))
            {
                $this->response->redirect($this->request->getPost('redirect'));
            }

            $comment = $this->comments->find($this->request->getPost('id'));

        $comment->save([
            'content'   => $this->request->getPost('content'),
            'name'      => $this->request->getPost('name'),
            'web'       => $this->request->getPost('web'),
            'mail'      => $this->request->getPost('mail'),
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        ]);

            $this->response->redirect($this->url->create('comments'));
        }

    /**
     * Save a comment.
     *
     * @param integer $id of comment to save.
     *
     * @return void
     */
    public function saveAction($name = null, $content = null, $email = null, $web = null, $id = 4) {

        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);


        $comment = $this->comments->find($id);
        $this->comments->find($id);
        if (!isset($id)) {
            die("Missing id");

        }


        $now = date_default_timezone_set('Europe/London');;

        $comment->name = $name;
        var_dump($name);
        $comment->content = $content;
        $comment->email = $email;
        $comment->web = $web;

        $comment->updated = $now;
        $this->comments->save();

        $url = $this->url->create('redovisning');
        $this->response->redirect($url);
    }

    /**
     * Find and return all comments.
     *
     * @return array with all comments.
     */
    public function findAll($key = null) {
        $comments = $this->session->get('comments', []);
        if (isset($comments[$key]))
            return $comments[$key];
    }


    public function listAction()
    {
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);

        $allComments = $this->comments->findAll();

        $this->views->add('comment/list-all', [
            'title'       => 'Kommentarer',
            'comments' => $allComments
        ]);
    }

    public function removeAction($id = null)
    {
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);

        if (!isset($id)) {
            die("Missing id");
        }

        $this->comments->delete($id);

        $this->response->redirect($this->request->getPost('redirect'));
    }


    public function editAction($id = null)
    {
        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);

        if(!isset($id)) {
            die("Missing id");
        }

        $comment = $this->comments->find($id);

        $this->views->add('comment/edit', [
            'comment' => $comment
        ]);
    }
    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction($key = '_no-key') {

        $this->comments = new \Anax\Comment\Comment();
        $this->comments->setDI($this->di);

        $all = $this->comments->findAll($key);

        $this->views->add('comment/list-all', [
            'comments' => $all,
            'key' => $key,
        ]);
    }
    /**
     * View all comments.
     *
     * @return void
     */
    public function menuAction() {

        $this->views->add('comment/user', [
        ]);
    }


} 