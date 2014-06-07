<?php

namespace Anax\Question;

class Projectquestion extends \Anax\MVC\CDatabaseModel
{


    /**
     * Set object properties.
     *
     * @param array $properties with properties to set.
     *
     * @return void
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
     * Get object properties.
     *
     * @return array with object properties.
     */
    public function getProperties()
    {
        $properties = get_object_vars($this);
        unset($properties['di']);
        unset($properties['db']);

        return $properties;
    }

    /**
     * Get the table name.
     *
     * @return string with the table name.
     */
    public function getSource()
    {
        return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1)));
    }

    public function findAll()
    {
        $this->db->select('projectquestion.*, count(pa.question_id) as numComments')
            ->from($this->getSource());

        $this->db
        ->join('projectanswer as pa', '(pa.question_id = projectquestion.id)')
        ->groupBy('pa.question_id');


        /* SELECT projectquestion . * , COUNT( projectanswer.question_id )
FROM  `projectquestion`
INNER JOIN  `projectanswer`
WHERE projectanswer.question_id = projectquestion.id
GROUP BY projectanswer.question_id
LIMIT 0 , 30*/

        if(isset($_GET['order_by'])) {
            if($_GET['order_by'] == 'desc') {
                $this->db->orderBy($this->getSource() .'.points DESC');
            } else if($_GET['order_by'] == 'asc') {
                $this->db->orderBy($this->getSource() .'.points ASC');
            }
        } else {
            $this->db->orderBy($this->getSource() .'.created DESC');
        }


        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }

    public function findAllTags()
    {
        $this->db->select()
            ->from('projecttags');

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }

    public function findTags($id)
    {
        $this->db->select()
            ->from('question_tags')
            ->where("tag_id = ?")
            ->join('projectquestion as pq', '(pq.id = question_tags.question_id)')
            ->join('projecttags as pt', '(question_tags.tag_id = pt.id)');


        $this->db->execute([$id]);
        return $this->db->fetchAll();

    }

    public function getTag($id){
        $this->db->select()
            ->from('projecttags')
            ->where("id = ?");

        $this->db->execute([$id]);
        return $this->db->fetchAll();
    }

    public function findLatest()
    {
        $this->db->select('projectquestion.id AS q_id , projectquestion.created AS created')
            ->from($this->getSource())
            ->where("id = ?")
            ->join('projectuser AS pu', '(pu.id = projectquestion.id)')
            ->orderBy($this->getSource() .'.created DESC');

        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }


    /**
     * Find and return specific.
     *
     * @return this
     */
    public function find($id)
    {
        $this->db->select()
            ->from($this->getSource())
            ->where("id = ?");

        $this->db->execute([$id]);
        return $this->db->fetchInto($this);

    }

    public function findjoin($id)
    {
        $this->db->select()
            ->from($this->getSource())
            ->where("projectquestion.id = ?");
        $this->db->execute([$id]);
        $this->db->fetchInto($this);

        $this->db->select('pt.tag')
            ->from($this->getSource() . ' as pq')
            ->where('pq.id = ?')
            ->join('question_tags as qt', '(qt.question_id = pq.id)')
            ->join('projecttags as pt', '(qt.tag_id = pt.id)');


        $this->db->execute([$id]);
        $tags = $this->db->fetchAll();

        $tagsen = array();
        foreach($tags as $tag) {
            $tagsen[] = $tag->tag;
        }

        $this->tags = $tagsen;

        return $this;

#        $this->db->execute([$id]);
        # return $this->db->fetchInto($this);

    }

    public function findAnswer($id)
    {
        $this->db->select()
            ->from('projectanswer')
            ->where('question_id = ?')
            ->orderBy('projectanswer.thumbs DESC');


        $this->db->execute([$id]);

        $result = $this->db->fetchAll();


        foreach($result as $k => $val) {
            $this->db->select()
                ->from('answer_comment')
                ->where('answer_id = ?')
                ->orderBy('answer_comment.created ASC');


            $this->db->execute([$val->id]);
            $comments = $this->db->fetchAll();
            $result[$k]->comments = $comments;
        }

        return $result;


    }

    public function findAnswerComment($id)
    {
        $this->db->select()
            ->from('answer_comment')
            ->where('answer_id = ?')
        ;


        $this->db->execute([$id]);
        return $this->db->fetchAll();


    }

    public function findAnswerQuestion($questionId, $id)
    {
        $this->db->select()
            ->from('projectanswer')
            ->where('question_id = ? AND id = ?');


        $this->db->execute([$questionId, $id]);
        return $this->db->fetchAll();


    }

    public function findAllAnswersByUser($username)
    {
        $this->db->select()
            ->from('answers')
            ->where('acronym = ?');

        $this->db->execute([$username]);
        return $this->db->fetchAll();
    }

    public function findQuestionComment($id)
    {
        $this->db->select()
            ->from('question_comment')
            ->where('question_id = ?');

        $this->db->execute([$id]);
        return $this->db->fetchAll();
    }


    public function NumberPosts($values = [])
    {
        $this->db->insert(
            'projectuser',
            ['posts']

        );

        $this->db->execute([
            $values['posts']
        ]);

    }

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

    public function canVoteOnQuestion($questionId, $userId)
    {
        $this->db->select()
            ->from('question_vote')
            ->where('user_id = ? AND question_id = ?');

        $this->db->execute([$userId, $questionId]);
        $results = $this->db->fetchAll();

        if(count($results) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function addVotedStatusToQuestion($questionId, $userId){
        $this->db->insert(
            'question_vote',
            ['question_id', 'user_id']
        );

        $this->db->execute([
            $questionId,
            $userId
        ]);

        return true;
    }

    public function changeQuestionVote($questionId, $value)
    {
        $this->db->select('points')
            ->from($this->getSource())
            ->where('id = ?');
        $this->db->execute([$questionId]);
        $results = $this->db->fetchAll();
        $results = array_pop($results);
        $points = $results->points;

        $value = $points + $value;

        $this->db->update(
            $this->getSource(),
            ['points'],
            [$value],
            "id = ?");
        return $this->db->execute([$questionId]);
    }

    public function canVoteOnAnswer($answerId, $userId)
    {
        $this->db->select()
            ->from('answer_vote')
            ->where('user_id = ? AND answer_id = ?');

        $this->db->execute([$userId, $answerId]);
        $results = $this->db->fetchAll();

        if(count($results) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function acceptedanswer($id)
    {
        $this->db->select()
            ->from('projectanswer')
            ->where('thumbs = 30');

        $this->db->execute([$id]);
        $results = $this->db->fetchAll();

        if(count($results) > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function addVotedStatusToAnswer($answerId, $userId){
        $this->db->insert(
            'answer_vote',
            ['answer_id', 'user_id']
        );

        $this->db->execute([
            $answerId,
            $userId
        ]);

        return true;
    }

    public function changeAnswerVote($answerId, $value)
    {
        $this->db->select('thumbs')
            ->from('projectanswer')
            ->where('id = ?');
        $this->db->execute([$answerId]);
        $results = $this->db->fetchAll();
        $results = array_pop($results);
        $thumbs = $results->thumbs;

        $value = $thumbs + $value;

        $this->db->update(
            'projectanswer',
            ['thumbs'],
            [$value],
            "id = ?");
        return $this->db->execute([$answerId]);
    }



    public function addTagToQuestion($questionId, $tagId)
    {

        $this->db->insert(
            'question_tags',
            ['question_id', 'tag_id']
        );

        $this->db->execute([
            $questionId,
            $tagId
        ]);


        $this->db->select()
            ->from('projecttags')
            ->where('id = ?');

        $this->db->execute([$tagId]);
        $taggarna = $this->db->fetchAll();

        if(count($taggarna) > 0) {
            $taggarna = array_pop($taggarna);
        }

        $updatedValue = ++$taggarna->usedNoTimes;

        $this->db->update('projecttags',
            ['usedNoTimes'],
            [$updatedValue],
            "id = ?");
        $this->db->execute([$tagId]);



        return true;
    }

    public function saveAnswer($values = [])
    {
        $this->db->insert(
            'projectanswer',
            ['question_id', 'acronym', 'email', 'content', 'created', 'thumbs']

        );

        $this->db->execute([
            $values['question_id'],
            $values['acronym'],
            $values['email'],
            $values['content'],
            $values['created'],
            $values['thumbs']
        ]);
    }

    public function saveAnswerComment($values = [])
    {
        $this->db->insert(
            'answer_comment',
            ['answer_id', 'content', 'created']

        );

        $this->db->execute([
            $values['answer_id'],
            $values['content'],
            $values['created']
        ]);

        return true;
    }

    public function saveQuestionComment($values = [])
    {
        $this->db->insert(
            'question_comment',
            ['question_id', 'content', 'created']

        );

        $this->db->execute([
            $values['question_id'],
            $values['content'],
            $values['created']
        ]);

        return true;
    }



}