<!DOCTYPE html>
<html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php Yii::app()->bootstrap->registerCss(); ?>
    <?php Yii::app()->bootstrap->registerYiiCss(); ?>
    
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon" />
    <title><?php echo CHtml::encode(Yii::app()->name . ' - ' . $this->pageTitle); ?></title>
  </head>
  
  <body>
    <h2 style='margin-bottom:10px;'><?php echo $this->pageTitle; ?></h2>

    <?php echo $content; ?>    
  </body>
</html>
<script>//window.print();</script>
