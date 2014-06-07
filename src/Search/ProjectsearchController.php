<?php

namespace Anax\Search;

class ProjectsearchController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    /**
     * Initialize the controller.
     *
     * @return void
     */
    public function initialize()
    {
        $this->search = new \Anax\Search\Projectsearch();
        $this->search->setDI($this->di);
    }

    public function forAction()
    {
        /*$this->search = new \Anax\Search\Projectsearch();
        $this->search->setDI($this->di);
*/
        $for = $this->request->getPost('searchIn');
        $keyword = $this->request->getPost('keyword');

        if($for == "Category...")
        {
            echo("Missing category.");
        }


        if(empty($keyword))
        {
            echo("Missing keyword");
        }

        $searchResults = null;

        if($for == "Users")
        {
            $searchResults = $this->search->findAllUsers($keyword);


        }
        if($for == "Questions")
        {
            $searchResults = $this->search->findAllQuestions($keyword);

        }
        else if($for == "Tags")
        {
            $searchResults = $this->search->findAllTags($keyword);
        }



        $this->theme->setTitle("Searchresult for " . $keyword);
        $this->views->add('search/list', [
            'title' => $keyword,
            'searchResults' => $searchResults,
            'for'	=> $for,
        ]);

    }
}