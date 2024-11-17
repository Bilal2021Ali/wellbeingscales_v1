<div class="main-content">
    <div class="page-content">
        <?php $this->load->view("AR/Ministry/inc/question_categories", [
            "showQuestionsReport" => true,
            "link" => "counter-questions",
            'hideQuestionsCode' => true
        ]); ?>
    </div>
</div>