<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ReviewFact */

$this->title = 'Create Review Fact';
$this->params['breadcrumbs'][] = ['label' => 'Review Facts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="review-fact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<div>
	<!-- <form name="testPost" action="http://localhost:7000/v1/review-facts" method="post"> -->
	<form name="testPost" action="http://api.ondetem.tk/v1/review-facts" method="post">
		<textarea name="jsonData">
			
		</textarea>

		<input type="submit" name="Send">
	</form>
</div>
