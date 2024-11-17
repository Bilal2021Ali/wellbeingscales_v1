<?php
/**
 * @var Collection $all
 * @var Collection $passed
 * @var string $language
 */

use Illuminate\Support\Collection;

$hasPassed = fn(int $id) => $passed->contains(fn($item) => $item['Task_Id'] == $id);
?>
<style>
    .InfosCards * {
        color: #fff;
    }

    .InfosCards .card-body {
        border-radius: 5px;
    }

    .InfosCards .card {
        box-shadow: 11px 7px 20px 0 rgba(0, 0, 0, 0.44);
        transition: 0.2s all;
    }

    .InfosCards .card:hover {
        transform: scale(1.02);
        transition: 0.2s all;
    }

    .InfosCards h4,
    .InfosCards p {
        color: #fff;
        cursor: default;
    }


    .question {
        margin: 0.2rem 0;
    }

    .question .card-body {
        padding: .5rem;
    }

    .question-body {
        display: flex;
        justify-content: space-between;
        font-size: 1rem;
        color: #fff;
        font-weight: bold;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px">
            <?= __("title") ?>
        </h4>

        <div class="row">
            <div class="col-lg-4">
                <?php $this->load->view("Shared/TaskReport/inc/counter-card", [
                    'name' => __('total'),
                    'value' => $all->count(),
                    'color' => '#2196F3'
                ]) ?>
            </div>
            <div class="col-lg-4">
                <?php $this->load->view("Shared/TaskReport/inc/counter-card", [
                    'name' => __('passed'),
                    'value' => $passed->count(),
                    'color' => '#4CAF50'
                ]) ?>
            </div>
            <div class="col-lg-4">
                <?php $this->load->view("Shared/TaskReport/inc/counter-card", [
                    'name' => __('skipped'),
                    'value' => $all->count() - $passed->count(),
                    'color' => '#E91E63'
                ]) ?>
            </div>
        </div>

        <?php foreach ($all as $task) { ?>
            <div class="card question">
                <div class="card-body <?= $hasPassed($task['id']) ? 'bg-success' : 'bg-danger' ?>">
                    <div class="question-body">
                        <p class="mb-0 text-white"><?= $task['task_' . $language] ?></p>
                        <i class="uil uil-<?= $hasPassed($task['id']) ? 'check-circle' : 'times-circle' ?>"></i>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
