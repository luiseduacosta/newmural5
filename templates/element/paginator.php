<?php // PaginatorHelper ?>
<?php // $this->Paginator->setTemplates(['nextActive' => '<li class="page-item"><a class="page-link" rel="próximo" href="{{url}}">{{text}}</a></li>']); ?>
<?php // $this->Paginator->setTemplates(['nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>']); ?>
<?php // $this->Paginator->setTemplates(['prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}">{{text}}</a></li>']); ?>
<?php // $this->Paginator->setTemplates(['prevDisabled' => '<li class="page-item disabledá"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>']); ?>
<?php // $this->Paginator->setTemplates(['counterRange' => '{{start}} - {{end}} of {{count}}']); ?>
<?php // $this->Paginator->setTemplates(['counterPages' => '{{page}} of {{pages}}']); ?>
<?php $this->Paginator->setTemplates(['first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php // $this->Paginator->setTemplates(['number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php // $this->Paginator->setTemplates(['current' => '<li class="page-item active"><a class="page-link" href="">{{text}}</a></li>']); ?>

<?php // $this->Paginator->setTemplates(['ellipsis' => '<li class="ellipsis">&hellip;</li>']); ?>
<?php // $this->Paginator->setTemplates(['sort' => '<a href="{{url}}">{{text}}</a>']); ?>
<?php // $this->Paginator->setTemplates(['sortAsc' => '<a class="asc" href="{{url}}">{{text}}</a>']); ?>
<?php // $this->Paginator->setTemplates(['sortDesc' => '<a class="desc" href="{{url}}">{{text}}</a>']); ?>
<?php // $this->Paginator->setTemplates(['sortAscLocked' => '<a class="asc locked" href="{{url}}">{{text}}</a>']); ?>
<?php // $this->Paginator->setTemplates(['sortDescLocked' => '<a class="desc locked" href="{{url}}">{{text}}</a>']); ?>

<!-- templates/element/paginator.php -->
<div class="row">
  <ul class="pagination justify-content-center">
    <?= $this->Paginator->first('Primeiro', [
      'templates' => [
        'first' => '<li class="page-item"><a class="btn btn-primary" href="{{url}}">{{text}}</a></li>'
      ]
    ]) ?>
    <?= $this->Paginator->prev('< ' . __('anterior'), [
      'templates' => [
        'prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}">{{text}}</a></li>',
        'prevDisabled' => '<li class="page-item disabled"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>'
      ]
    ]) ?>
    <?= $this->Paginator->numbers([
      'templates' => [
        'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
        'current' => '<li class="page-item active"><a class="page-link" href="">{{text}}</a></li>'
      ]
    ]) ?>
    <?= $this->Paginator->next(__('próximo') . ' >', [
      'templates' => [
        'nextActive' => '<li class="page-item"><a class="page-link" rel="próximo" href="{{url}}">{{text}}</a></li>',
        'nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>'
      ]
    ]) ?>
    <?= $this->Paginator->last(__('Último') . ' >>', [
      'templates' => [
        'last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>'
      ]
    ]) ?>
  </ul>
  <p class="text-center">
    <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro de um total de {{count}}.'), [
      'templates' => [
        'counterRange' => '{{start}} - {{end}} of {{count}}',
        'counterPages' => '{{page}} of {{pages}}'
      ]
    ]) ?>
  </p>
</div>
<!-- end templates/element/paginator.php -->