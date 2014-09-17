<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('year')); ?>:</b>
	<?php echo CHtml::encode($data->year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_parsed_tweet_id')); ?>:</b>
	<?php echo CHtml::encode($data->last_parsed_tweet_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_from')); ?>:</b>
	<?php echo CHtml::encode($data->parse_from); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parse_to')); ?>:</b>
	<?php echo CHtml::encode($data->parse_to); ?>
	<br />


</div>