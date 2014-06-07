<?php

namespace Phpmvc\Comment;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;



    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction()
    {
        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $all = $comments->findAll();

        $this->views->add('comment/comments', [
            'comments' => $all,
        ]);
    }



    /**
     * Add a comment.
     *
     * @return void
     */
    public function addAction()
    {

        $now =  date_default_timezone_set('Europe/London');

        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);

            $this->users->save([
                'content' =>  $_POST['content'],
                'name' =>  $_POST['name'],
                'web' =>  $_POST['web'],
            'mail' =>  $_POST['mail'],
            'timestamp' => time(),
            'ip'        => $this->request->getServer('REMOTE_ADDR'),
        ]);
    }



    /**
     * Remove all comments.
     *
     * @return void
     */
    public function removeAllAction()
    {
        $isPosted = $this->request->getPost('doRemoveAll');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->deleteAll();

        $this->response->redirect($this->request->getPost('redirect'));
    }

    public function saveAction()
    {
        $isPosted = $this->request->getPost('save');

        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);

        $comments->update();

        $this->response->redirect($this->request->getPost('redirect'));
    }
}
