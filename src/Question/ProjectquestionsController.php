<?php

namespace Anax\Question;

class ProjectquestionsController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->question = new \Anax\Question\Projectquestion();
        $this->question->setDI($this->di);

        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);
    }

    public function listAllAction()
    {
        $this->questions = new \Anax\Question\Projectquestion();
        $this->questions->setDI($this->di);

        $all = $this->questions->findAll();


        foreach ($all as $k => $question) {
            $userExists = $this->users->userExists($question->acronym);
            $all[$k]->exists = $userExists;
        }

        $this->theme->setTitle("Questions");
        $this->views->add('question/list-all', [
            'questions' => $all,

        ]);
    }

    public function listAllTagsAction()
    {
        $this->tags = new \Anax\Question\Projectquestion();
        $this->tags->setDI($this->di);

        $tag = $this->tags->findAllTags();

        $this->theme->setTitle("Tags");
        $this->views->add('tag/list', [
            'tags' => $tag,

        ]);
    }


    public function idAction($id = null)
    {
        $this->questions = new \Anax\Question\Projectquestion();
        $this->questions->setDI($this->di);

        $this->users = new \Anax\Users\Projectuser();
        $this->users->setDI($this->di);

        $questions = $this->questions->findjoin($id);
        $answers = $this->questions->findAnswer($id);
        $questionComments = $this->questions->findQuestionComment($id);

        $answersComments = $this->questions->findAnswerComment($id);

        $userExists = $this->users->userExists($questions->acronym);

        $this->theme->setTitle("View question with id");
        $this->views->add('question/view', [
            'questions' => $questions,
            'answers' => $answers,
            'questionComments' => $questionComments,
            'answerComments' => $answersComments,
            'userExists' => $userExists,
        ]);
    }

    public function viewAddAction()
    {
        $this->tags = new \Anax\Question\Projectquestion();
        $this->tags->setDI($this->di);

        $tags = $this->tags->findAllTags();

        $this->theme->setTitle("Add question");
        $this->views->add('question/add', [
            'tags' => $tags,
        ]);
    }

    public function addAction()
    {
        $this->questions = new \Anax\Question\Projectquestion();
        $this->questions->setDI($this->di);

        if (!$this->request->getPost('add')) {
            die("Missing info.");
        }

        $res = $this->questions->save([
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'acronym' => $this->request->getPost('acronym'),
            'created' => date('Y-m-d H:i'),
            'updated' => date('Y-m-d H:i'),
            'user_id' => $this->session->get('user_info')['id'],
        ]);

        $questionId = $this->questions->id;


        foreach ($this->request->getPost('tags') as $tagId) {
            $this->questions->addTagToQuestion($questionId, $tagId);
        }
        /*
                $this->questions->NumberPosts([
                    'posts' => + 1,
                    'acronym' 	=> $this->request->getPost('acronym'),
                ]);*/

        $this->response->redirect($this->url->create('questions/id/' . $this->questions->id));


    }


    public function tagidAction($id = null)
    {
        $this->tags = new \Anax\Question\Projectquestion();
        $this->tags->setDI($this->di);

        $tags = $this->tags->findTags($id);
        $lookingforthistag = $this->tags->getTag($id);


        $this->theme->setTitle("View tag with id");
        $this->views->add('tag/view', [
            'tags' => $tags,
            'tag' => array_pop($lookingforthistag)
        ]);
    }

    public function addAnswerAction()
    {
        $this->questions = new \Anax\Question\Projectquestion();
        $this->questions->setDI($this->di);


        $content = $this->textFilter->markdown($this->request->getPost('content'), 'shortcode, markdown');
        $this->questions->saveAnswer([
            'question_id' => $this->request->getPost('q_id'),
            'acronym' => $this->session->get('user_info')['acronym'],
            'email' => $this->session->get('user_info')['email'],
            'content' => $content,
            'created' => date('Y-m-d H:i'),
            'thumbs' => 0,
        ]);

        if (!$this->request->getPost('doAnswer')) {
            die("Missing info.");
        }

        $this->response->redirect($this->url->create('questions/id/' . $this->request->getPost('q_id')));
    }

    public function latestAction()
    {
        $this->questions = new \Anax\Question\Projectquestion();
        $this->questions->setDI($this->di);

        $questions = $this->questions->findLatest(5);


        return $questions;
    }

    public function voteAction($id = null, $value = null)
    {

        $this->questions = new \Anax\Question\Projectquestion();
        $this->questions->setDI($this->di);

        $questions = $this->questions->find($id);

        if (isset($_SESSION['logged_in'])) {
            if (!$_SESSION['logged_in']) {
                $this->flash->add('error', 'Please sign in to vote!');
                $this->theme->setVariable('title', "Flash")
                    ->setVariable('main', $this->flash->get('icons'));
            } else {
                $canVote = $this->questions->canVoteOnQuestion($id, $_SESSION['user_info']['id']);

                if ($canVote == true) {
                    if ($value == 'up') {
                        $this->questions->changeQuestionVote($id, 1);
                        $this->response->redirect($this->url->create('questions/id/' . $this->questions->id));
                    } elseif ($value == 'down') {
                        $this->questions->changeQuestionVote($id, -1);
                        $this->response->redirect($this->url->create('questions/id/' . $this->questions->id));


                    }
                    $this->questions->addVotedStatusToQuestion($id, $_SESSION['user_info']['id']);
                } else {
                    $this->flash->add('warning', 'You have already voted on this question!');
                    $this->theme->setVariable('title', "Flash")
                        ->setVariable('main', $this->flash->get('icons'));
                }
            }
        } else {
            $this->flash->add('error', 'Please sign in to vote!');
            $this->theme->setVariable('title', "Flash")
                ->setVariable('main', $this->flash->get('icons'));

        }

    }

    public function voteAnswerAction($questionId = null, $id, $value = null)
    {
        $this->questions = new \Anax\Question\Projectquestion();
        $this->questions->setDI($this->di);

        $answers = $this->questions->findAnswerQuestion($questionId, $id);


        if (isset($_SESSION['logged_in'])) {
            if (!$_SESSION['logged_in']) {
                $this->flash->add('error', 'Please sign in to vote!');
                $this->theme->setVariable('title', "Flash")
                    ->setVariable('main', $this->flash->get('icons'));
            } else {
                $canVote = $this->questions->canVoteOnAnswer($id, $_SESSION['user_info']['id']);

                if ($canVote == true) {
                    if ($value == 'up') {
                        echo "upp";
                        $this->questions->changeAnswerVote($id, 1);
                        $this->response->redirect($this->url->create('questions/id/' . $questionId));

                    } elseif ($value == 'down') {
                        $this->questions->changeAnswerVote($id, -1);
                        $this->response->redirect($this->url->create('questions/id/' . $questionId));


                    }
                    $this->questions->addVotedStatusToAnswer($id, $_SESSION['user_info']['id']);
                } else {
                    $this->flash->add('warning', 'You have already voted on this answer!');
                    $this->theme->setVariable('title', "Flash")
                        ->setVariable('main', $this->flash->get('icons'));
                }
            }
        } else {
            $this->flash->add('error', 'Please sign in to vote!');
            $this->theme->setVariable('title', "Flash")
                ->setVariable('main', $this->flash->get('icons'));

        }

    }

    public function addQuestionCommentAction()
    {
        $this->comment = new \Anax\Question\Projectquestion();
        $this->comment->setDI($this->di);

        if (!$this->request->getPost('questionComment')) {
            die("Missing info.");
        }


        $content = $this->textFilter->markdown($this->request->getPost('content'), 'shortcode, markdown');
        $res = $this->comment->saveQuestionComment([
            'question_id' => $this->request->getPost('q_id'),
            'content' => $content,
            'created' => date('Y-m-d H:i'),
        ]);

        $this->response->redirect($this->url->create('questions/id/' . $this->request->getPost('q_id')));
    }

    public function addAnswerCommentAction()
    {
        $this->comment = new \Anax\Question\Projectquestion();
        $this->comment->setDI($this->di);

        if (!$this->request->getPost('answerComment')) {
            die("Missing info.");
        }


        $content = $this->textFilter->markdown($this->request->getPost('content'), 'shortcode, markdown');
        $res = $this->comment->saveAnswerComment([
            'answer_id' => $this->request->getPost('a_id'),
            'content' => $content,
            'created' => date('Y-m-d H:i'),
        ]);

        $this->response->redirect($this->url->create('questions/id/' . $this->request->getPost('q_id')));
    }
}