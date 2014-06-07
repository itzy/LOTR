<?php

namespace Anax\Users;

/**
 * Model for Users.
 *
 */
class Projectuser extends \Anax\MVC\CDatabaseModel
{

    /**
     * Set object properties.
     *
     * @param array $properties with properties to set.
     *
     * @return void
     */
/*    public function initialize()
    {
        $this->question = new \Anax\Question\ProjectquestionsController();
        $this->question->setDI($this->di);
    }
*/
    public function setProperties($properties)
    {
        // Update object with incoming values, if any
        if (!empty($properties)) {
            foreach ($properties as $key => $val) {
                $this->$key = $val;
            }
        }
    }

    /**
     * Save current object/row.
     *
     * @param array $values key/values to save or empty to use object properties.
     *
     * @return boolean true or false if saving went okey.
     */
    public function save($values = [])
    {
        $this->setProperties($values);
        $values = $this->getProperties();

        if (isset($values['id'])) {
            return $this->update($values);
        } else {
            return $this->create($values);
        }
    }

    /**
     * Create new row.
     *
     * @param array $values key/values to save.
     *
     * @return boolean true or false if saving went okey.
     */
    public function create($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        $this->db->insert(
            $this->getSource(),
            $keys
        );

        $res = $this->db->execute($values);

        $this->id = $this->db->lastInsertId();

        return $res;
    }

    /**
     * Update row.
     *
     * @param array $values key/values to save.
     *
     * @return boolean true or false if saving went okey.
     */
    public function update($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        // Its update, remove id and use as where-clause
        unset($keys['id']);
        $values[] = $this->id;

        $this->db->update(
            $this->getSource(),
            $keys,
            "id = ?"
        );

        return $this->db->execute($values);
    }

    public function updateprofile($values)
    {
        $keys   = array_keys($values);
        $values = array_values($values);

        $this->db->update(
            $this->getSource(),
            $keys
        );

        return $this->db->execute($values);
    }

    public function findByAcronym($acronym){
        $this->db->select()
            ->from($this->getSource())
            ->where("acronym = ?");

        $this->db->execute([$acronym]);
        return $this->db->fetchInto($this);

    }

    public function findEmail($acronym){
        $this->db->select()
            ->from($this->getSource())
            ->where("acronym = ?");

        $this->db->execute([$acronym]);
        return $this->db->fetchInto($this);

    }

    public function findQuestions($id){
        $this->db->select()
            ->from('projectquestion')
            ->where("user_id = ?");

        $this->db->execute([$id]);
        return $this->db->fetchAll();
    }

    public function findAnswers($acronym){
        $this->db->select()
            ->from('projectanswer')
            ->where("acronym = ?");

        $this->db->execute([$acronym]);
        return $this->db->fetchAll();
    }

    public function userExists($acronym){

        $this->db->select()
            ->from('projectuser')
            ->where('acronym = ?');


        $this->db->execute([$acronym]);

        $res = $this->db->fetchAll();

        if(count($res) > 0) {
            return true;
        }
        return false;

    }


}