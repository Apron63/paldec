<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */

$this->title = 'Информация по счетчикам';
?>
<div class="modal fade" tabindex="-1" role="dialog" id="x-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Укажите дату</h4>
            </div>
            <div class="modal-body" id="x-contens">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="run-modal">Выполнить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
            </div>
        </div>
    </div>
</div>

<div class="site-index">

    <div class="col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Отчеты</h3>
            </div>
            <div class="panel-body">
                <?= Html::button('Просроченные', ['class' => 'btn btn-success', 'id' => 'get-modal']) ?>
                <?= Html::button('Акт потребления', ['class' => 'btn btn-success', 'id' => 'act-potr']) ?>
                <?= Html::button('<i class="glyphicon glyphicon-time"></i>', [
                    'id' => 'arh-button',
                    'class' => 'btn btn-default pull-right',
                    'data-toggle' => 'button',
                    'title' => 'Показать/скрыть счетчики в архиве'
                ])?>
            </div>
        </div>
    </div>

    <div class="col-sm-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Организации</h3>
            </div>
            <div class="panel-body">

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'id' => 'company-table',
                    'columns' => [
                        [
                            'attribute'=>'short_name',
                            'label' => 'Организация',
                            'format'=>'raw',
                            'value' => function($model) {
                                return '<span  style="white-space: normal;">'
                                    . Html::button($model->short_name, ['class' => 'btn btn-link get-counters', 'data-id' => $model->id])
                                    .  '</span>'
                                ;
                            },
                        ],

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'controller' => 'company',
                            'header' => Html::a('Создать', ['/company/create'], ['class' => 'btn btn-success', 'title' => 'Добавить новую организацию']),
                            'template' => '{update} {delete}',
                            'contentOptions' => [
                                'width' => 100,
                            ],
                            'buttons' => [
                                /*'select' => function ($url, $model) {
                                    return Html::button('<span class="glyphicon glyphicon-zoom-in"></span>',  [
                                        'title' => 'Выбрать',
                                        'class'=>'btn btn-primary btn-xs get-counters',
                                        'data-id' => $model->id,
                                    ]);
                                },*/
                                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                                        'title' => 'Редактировать',
                                        'class'=>'btn btn-primary btn-xs',
                                    ]);
                                },
                                'delete' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                        'title' => 'Удалить',
                                        'class'=>'btn btn-primary btn-xs',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Действительно удалить организацию?',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>

    <div class="col-sm-7">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Счетчики</h3>
            </div>
            <div class="panel-body">
                <div id="counter-content"></div>
            </div>
        </div>

    </div>
</div>


<?php
$script = <<< JS
$(window).load(function(){
    $.ajax({
        url: "counter/get-company-id"
    })
    .done(function(id){
        getCounters(id);
    }).fail(function(data){
    });
    
    $.ajax({
        url: "counter/get-arh-status"
    })
    .done(function(status){
        //alert(status);
        //$("#arh-button").attr("aria-pressed", status);
        $("#arh-button").attr("aria-pressed", false);
    }).fail(function(data){
        //alert(999);
    });
});

$(".get-counters").click(function() {
    var id = $(this).attr("data-id");
    getCounters(id);
});

function getCounters(id){
    $.ajax({
        url: "counter/get-list",
        data: {id: id}
    })
    .done(function(data){
        $("#counter-content").html(data);
    })
    .fail(function(){
    });
};

$("#get-modal").click(function(){
    $.ajax({
        url: "site/fill-modal"
    }).done(function(data){
        $("#x-contens").html(data);
        $("#run-modal").attr("data-href", "report/counter-expired");
        $("#x-modal").modal("toggle");    
    });
});

$("#act-potr").click(function(){
    $.ajax({
        url: "site/fill-modal"
    }).done(function(data){
        $("#x-contens").html(data);
        $("#run-modal").attr("data-href", "report/act-potr");
        $("#x-modal").modal("toggle");    
    });
});

$("#run-modal").click(function(){
    var x_date = $("#x-datepicker").val();
    document.location.href = $(this).attr("data-href") + "?date=" + x_date;
});

$("#arh-button").click(function(){
    var st = $(this).attr("aria-pressed");
    //alert(st);
    if (typeof st === 'undefined') st = false;
    $.ajax({
        url: "counter/set-arh-status",
        data: {status: st}
    });
})

JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>