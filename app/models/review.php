<?php

class Review
{
    private $user_id_reviewer;
    private $user_id_student;
    private $file_id;
    private $review_status;
    private $comment;

    public function __construct(
        $user_id_reviewer,
        $user_id_student,
        $file_id,
        $review_status,
        $comment
    ) {
        $this->user_id_reviewer = $user_id_reviewer;
        $this->user_id_student = $user_id_student;
        $this->file_id = $file_id;
        $this->review_status = $review_status;
        $this->comment = $comment;
    }

    // Getters and setters for each property
    public function getUserIdReviewer()
    {
        return $this->user_id_reviewer;
    }

    public function setUserIdReviewer($user_id_reviewer)
    {
        $this->user_id_reviewer = $user_id_reviewer;
    }

    public function getUserIdStudent()
    {
        return $this->user_id_student;
    }

    public function setUserIdStudent($user_id_student)
    {
        $this->user_id_student = $user_id_student;
    }

    public function getFileId()
    {
        return $this->file_id;
    }

    public function setFileId($file_id)
    {
        $this->file_id = $file_id;
    }

    public function getReviewStatus()
    {
        return $this->review_status;
    }

    public function setReviewStatus($review_status)
    {
        $this->review_status = $review_status;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}
?>
