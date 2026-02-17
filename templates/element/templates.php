<?php
/** 
 * @var \App\View\AppView $this
 * 
 */
?>

<?php // BreadcrumbsHelper ?>
<?php $this->Breadcrumbs->setTemplates(['wrapper' => '<ul{{attrs}}>{{content}}</ul>']); ?>
<?php $this->Breadcrumbs->setTemplates(['item' => '<li{{attrs}}><a href="{{url}}"{{innerAttrs}}>{{title}}</a></li>{{separator}}']); ?>
<?php $this->Breadcrumbs->setTemplates(['itemWithoutLink' => '<li{{attrs}}><span{{innerAttrs}}>{{title}}</span></li>{{separator}}']); ?>
<?php $this->Breadcrumbs->setTemplates(['separator' => '<li{{attrs}}><span{{innerAttrs}}>{{separator}}</span></li>']); ?>

<?php // FormHelper ?>
<?php // Used for button elements in button(). ?>
<?php $this->Form->setTemplates(['button' => '<button{{attrs}}>{{text}}</button>']); ?>
<?php // Used for checkboxes in checkbox() and multiCheckbox(). ?>
<?php $this->Form->setTemplates(['checkbox' => '<input type="checkbox" name="{{name}}" value="{{value}}"{{attrs}}>']); ?>
<?php // Input group wrapper for checkboxes created via control(). ?>
<?php $this->Form->setTemplates(['checkboxFormGroup' => '{{label}}']); ?>
<?php // Wrapper container for checkboxes. ?>
<?php $this->Form->setTemplates(['checkboxWrapper' => '<div class="checkbox">{{label}}</div>']); ?>
<?php // Error message wrapper elements. ?>
<?php $this->Form->setTemplates(['error' => '<div class="error-message" id="{{id}}">{{content}}</div>']); ?>
<?php // Container for error items. ?>
<?php $this->Form->setTemplates(['errorList' => '<ul>{{content}}</ul>']); ?>
<?php // Error item wrapper. ?>
<?php $this->Form->setTemplates(['errorItem' => '<li>{{text}}</li>']); ?>
<?php // File input used by file(). ?>
<?php $this->Form->setTemplates(['file' => '<input type="file" name="{{name}}"{{attrs}}>']); ?>
<?php // Fieldset element used by allControls(). ?>
<?php $this->Form->setTemplates(['fieldset' => '<fieldset class="border p-3 mb-4" {{attrs}}>{{content}}</fieldset>']); ?>
<?php // Open tag used by create(). ?>
<?php $this->Form->setTemplates(['formStart' => '<form{{attrs}}>']); ?>
<?php // Close tag used by end(). ?>
<?php $this->Form->setTemplates(['formEnd' => '</form>']); ?>
<?php // General grouping container for control(). Defines input/label ordering. ?>
<?php $this->Form->setTemplates(['formGroup' => '{{label}}{{input}}']); ?>
<?php // Wrapper content used to hide other content. ?>
<?php $this->Form->setTemplates(['hiddenBlock' => '<div style="display:none;">{{content}}</div>']); ?>
<?php // Generic input element. ?>
<?php $this->Form->setTemplates(['input' => '<div class="col-sm-9"><input type="{{type}}" name="{{name}}" class="form-control" {{attrs}}></div>']); ?>
<?php // Confirma input element. ?>
<?php $this->Form->setTemplates(['inputSubmit' => '<input type="{{type}}"{{attrs}}>']); ?>
<?php // Container element used by control(). ?>
<?php $this->Form->setTemplates(['inputContainer' => '<div class="row col-md-12" {{type}}{{required}}">{{content}}</div>']); ?>
<?php // Container element used by control() when a field has an error. ?>
<?php $this->Form->setTemplates(['inputContainerError' => '<div class="input {{type}}{{required}} error">{{content}}{{error}}</div>']); ?>
<?php // Label element when inputs are not nested inside the label. ?>
<?php $this->Form->setTemplates(['label' => '<label class="col-sm-3 form-label" {{attrs}}>{{text}}</label>']); ?>
<?php // Label element used for radio and multi-checkbox inputs. ?>
<?php $this->Form->setTemplates(['nestingLabel' => '{{hidden}}<label{{attrs}}>{{input}}{{text}}</label>']); ?>
<?php // Legends created by allControls(). ?>
<?php $this->Form->setTemplates(['legend' => '<legend class="h5">{{text}}</legend>']); ?>
<?php // Multi-Checkbox input set title element. ?>
<?php $this->Form->setTemplates(['multicheckboxTitle' => '<legend>{{text}}</legend>']); ?>
<?php // Multi-Checkbox wrapping container. ?>
<?php $this->Form->setTemplates(['multicheckboxWrapper' => '<fieldset{{attrs}}>{{content}}</fieldset>']); ?>
<?php // Option element used in select pickers. ?>
<?php $this->Form->setTemplates(['option' => '<option value="{{value}}"{{attrs}}>{{text}}</option>']); ?>
<?php // Option group element used in select pickers. ?>
<?php $this->Form->setTemplates(['optgroup' => '<optgroup label="{{label}}"{{attrs}}>{{content}}</optgroup>']); ?>
<?php // Select element, ?>
<?php $this->Form->setTemplates(['select' => '<select class="form-select" name="{{name}}"{{attrs}}>{{content}}</select>']); ?>
<?php // Multi-select element, ?>
<?php $this->Form->setTemplates(['selectMultiple' => '<select name="{{name}}[]" multiple="multiple"{{attrs}}>{{content}}</select>']); ?>
<?php // Radio input element, ?>
<?php $this->Form->setTemplates(['radio' => '<input class="form-check-input" type="radio" name="{{name}}" value="{{value}}"{{attrs}}>']); ?>
<?php // Wrapping container for radio input/label, ?>
<?php $this->Form->setTemplates(['radioWrapper' => '<div class="form-check form-check-inline">{{label}}{{input}}</div>']); ?>
<?php // Textarea input element, ?>
<?php $this->Form->setTemplates(['textarea' => '<div class="col-sm-9"><textarea name="{{name}}"{{attrs}}>{{value}}</textarea></div>']); ?>
<?php // Container for Confirma buttons. ?>
<?php $this->Form->setTemplates(['submitContainer' => '<div class="Confirma">{{content}}</div>']); ?>
<?php // Confirm javascript template for postLink() ?>
<?php $this->Form->setTemplates(['confirmJs' => '{{confirm}}']); ?>
<?php // selected class ?>
<?php $this->Form->setTemplates(['selectedClass' => 'selected']); ?>
<?php // required class ?>
<?php $this->Form->setTemplates(['requiredClass' => 'required']); ?>
<?php $this->Form->setTemplates(["dateWidget" => "{{day}}{{month}}{{year}}{{hour}}{{minute}}{{second}}{{meridian}}"]); ?>

<?php // PaginatorHelper ?>
<?php $this->Paginator->setTemplates(['nextActive' => '<li class="page-item"><a class="page-link" rel="próximo" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['nextDisabled' => '<li class="page-item disabled"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['prevDisabled' => '<li class="page-item disabledá"><a class="page-link" href="" onclick="return false;">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['counterRange' => '{{start}} - {{end}} of {{count}}']); ?>
<?php $this->Paginator->setTemplates(['counterPages' => '{{page}} of {{pages}}']); ?>
<?php $this->Paginator->setTemplates(['first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['current' => '<li class="page-item active"><a class="page-link" href="">{{text}}</a></li>']); ?>
<?php $this->Paginator->setTemplates(['ellipsis' => '<li class="ellipsis">&hellip;</li>']); ?>
<?php $this->Paginator->setTemplates(['sort' => '<a href="{{url}}">{{text}}</a>']); ?>
<?php $this->Paginator->setTemplates(['sortAsc' => '<a class="asc" href="{{url}}">{{text}}</a>']); ?>
<?php $this->Paginator->setTemplates(['sortDesc' => '<a class="desc" href="{{url}}">{{text}}</a>']); ?>
<?php $this->Paginator->setTemplates(['sortAscLocked' => '<a class="asc locked" href="{{url}}">{{text}}</a>']); ?>
<?php $this->Paginator->setTemplates(['sortDescLocked' => '<a class="desc locked" href="{{url}}">{{text}}</a>']); ?>

<?php // Default templates for HTML elements ?>
<?php $this->Html->setTemplates(['meta' => '<meta{{attrs}}>']); ?>
<?php $this->Html->setTemplates(['metalink' => '<link href="{{url}}"{{attrs}}>']); ?>
<?php $this->Html->setTemplates(['link' => '<a href="{{url}}"{{attrs}}>{{content}}</a>']); ?>
<?php $this->Html->setTemplates(['mailto' => '<a href="mailto:{{url}}"{{attrs}}>{{content}}</a>']); ?>
<?php $this->Html->setTemplates(['image' => '<img src="{{url}}"{{attrs}}>']); ?>
<?php $this->Html->setTemplates(['tableheader' => '<th{{attrs}}>{{content}}</th>']); ?>
<?php $this->Html->setTemplates(['tableheaderrow' => '<tr{{attrs}}>{{content}}</tr>']); ?>
<?php $this->Html->setTemplates(['tablecell' => '<td{{attrs}}>{{content}}</td>']); ?>
<?php $this->Html->setTemplates(['tablerow' => '<tr{{attrs}}>{{content}}</tr>']); ?>
<?php $this->Html->setTemplates(['block' => '<div{{attrs}}>{{content}}</div>']); ?>
<?php $this->Html->setTemplates(['blockstart' => '<div{{attrs}}>']); ?>
<?php $this->Html->setTemplates(['blockend' => '</div>']); ?>
<?php $this->Html->setTemplates(['tag' => '<{{tag}}{{attrs}}>{{content}}</{{tag}}>']); ?>
<?php $this->Html->setTemplates(['tagstart' => '<{{tag}}{{attrs}}>']); ?>
<?php $this->Html->setTemplates(['tagend' => '</{{tag}}>']); ?>
<?php $this->Html->setTemplates(['tagselfclosing' => '<{{tag}}{{attrs}}/>']); ?>
<?php $this->Html->setTemplates(['para' => '<p{{attrs}}>{{content}}</p>']); ?>
<?php $this->Html->setTemplates(['parastart' => '<p{{attrs}}>']); ?>
<?php $this->Html->setTemplates(['css' => '<link rel="{{rel}}" href="{{url}}"{{attrs}}>']); ?>
<?php $this->Html->setTemplates(['style' => '<style{{attrs}}>{{content}}</style>']); ?>
<?php $this->Html->setTemplates(['charset' => '<meta charset="{{charset}}">']); ?>
<?php $this->Html->setTemplates(['ul' => '<ul{{attrs}}>{{content}}</ul>']); ?>
<?php $this->Html->setTemplates(['ol' => '<ol{{attrs}}>{{content}}</ol>']); ?>
<?php $this->Html->setTemplates(['li' => '<li{{attrs}}>{{content}}</li>']); ?>
<?php $this->Html->setTemplates(['javascriptblock' => '<script{{attrs}}>{{content}}</script>']); ?>
<?php $this->Html->setTemplates(['javascriptstart' => '<script>']); ?>
<?php $this->Html->setTemplates(['javascriptlink' => '<script src="{{url}}"{{attrs}}></script>']); ?>
<?php $this->Html->setTemplates(['javascriptend' => '</script>']); ?>
<?php $this->Html->setTemplates(['confirmJs' => '{{confirm}}']); ?>
