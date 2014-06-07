<?php

namespace Anax\Search;

class Projectsearch extends \Anax\MVC\CDatabaseModel
{
    /**
     * Initialize the controller.
     *
     * @return void
     */

    public function findAllUsers($keyword)
    {
        $this->db->select()
            ->from('projectuser')
            ->where('acronym LIKE ?');

        $this->db->execute(["%" . $keyword . "%"]);
        return $this->db->fetchAll();
    }

    public function findAllQuestions($keyword)
    {
        $this->db->select()
            ->from('projectquestion')
            ->where('title LIKE ?');

        $this->db->execute(["%" . $keyword . "%"]);
        return $this->db->fetchAll();
    }

    public function findAllTags($keyword)
    {
        $this->db->select()
            ->from('projecttags')
            ->where('tag LIKE ?');

        $this->db->execute(["%" . $keyword . "%"]);
        return $this->db->fetchAll();
    }

}