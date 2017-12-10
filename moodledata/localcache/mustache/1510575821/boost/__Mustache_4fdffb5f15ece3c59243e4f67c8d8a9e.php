<?php

class __Mustache_4fdffb5f15ece3c59243e4f67c8d8a9e extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<span class="overlay-icon-container hidden" data-region="overlay-icon-container">
';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context, $indent . '    ');
        }
        $buffer .= $indent . '</span>
';

        return $buffer;
    }
}
