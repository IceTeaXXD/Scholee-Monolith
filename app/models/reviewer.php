<?php
class Reviewer extends User{
    private string $occupation;
    private int $score;

    public function addScore(int $add){
        $this->score += $add;
    }
}
?>