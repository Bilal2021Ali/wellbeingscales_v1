<div class="main-content">
    <div class="page-content">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4><?= $this->lang->line('category-title') ?> :</h4>
                        <p><?= $course['categoryTitle'] ?></p>
                        <h4><?= $this->lang->line('course-title') ?> : </h4>
                        <p><?= $course['Courses_Title'] ?></p>
                        <h4><?= $this->lang->line('language') ?> : </h4>
                        <p><?= $course['Language'] ?></p>
                        <h4><?= $this->lang->line('description') ?> : </h4>
                        <p><?= $course['Description'] ?></p>
                    </div>
                </div>
                <?php foreach ($topics as $topic) { ?>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title"><?= $topic['topicTitle'] ?></h3>
                            <p><?= $topic['topicDescription'] ?></p>
                            <hr>
                            <?php $i = 1; ?>
                            <ul>
                                <?php foreach (($resources[$topic['topicId']] ?? []) as $resource) { ?>
                                    <li><?= $i ?>. <?= $resource['coursesResourceTitle'] ?></li>
                                    <?php ++$i; ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>