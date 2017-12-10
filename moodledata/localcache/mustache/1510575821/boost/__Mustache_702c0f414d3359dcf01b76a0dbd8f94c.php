<?php

class __Mustache_702c0f414d3359dcf01b76a0dbd8f94c extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div data-region="event-list-container"
';
        $buffer .= $indent . '     data-limit="';
        $blockFunction = $context->findInBlock('limit');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            $buffer .= '20';
        }
        $buffer .= '"
';
        $buffer .= $indent . '     data-course-id="';
        $blockFunction = $context->findInBlock('courseid');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '"
';
        $buffer .= $indent . '     data-last-id="';
        $blockFunction = $context->findInBlock('lastid');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '"
';
        $buffer .= $indent . '     data-midnight="';
        $value = $this->resolveValue($context->find('midnight'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"
';
        $buffer .= $indent . '     id="event-list-container-';
        $blockFunction = $context->findInBlock('courseid');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        }
        $buffer .= '">
';
        $buffer .= $indent . '
';
        $buffer .= $indent . '    <div data-region="event-list-content">
';
        $buffer .= $indent . '        ';
        if ($parent = $this->mustache->loadPartial('block_myoverview/event-list-group')) {
            $context->pushBlockContext(array(
                'title' => array($this, 'blockEa4a9f0731767159e863e1db7e72336d'),
                'extratitleclasses' => array($this, 'block38999efb548e1543b72f05033be446fd'),
                'startday' => array($this, 'blockEa230cf4d288c3881a266d7b3094d7c5'),
                'endday' => array($this, 'blockE13f09ec51e6aa10c3789885dab1c67f'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= '        ';
        if ($parent = $this->mustache->loadPartial('block_myoverview/event-list-group')) {
            $context->pushBlockContext(array(
                'title' => array($this, 'block06df5a9d0e1d780d3c87f4275a8bcb47'),
                'extratitleclasses' => array($this, 'blockD41d8cd98f00b204e9800998ecf8427e'),
                'startday' => array($this, 'blockE13f09ec51e6aa10c3789885dab1c67f'),
                'endday' => array($this, 'blockE052079a625ca42b568ba24af19cc7eb'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= '        ';
        if ($parent = $this->mustache->loadPartial('block_myoverview/event-list-group')) {
            $context->pushBlockContext(array(
                'title' => array($this, 'block57cf602548cea5271a14e50954788621'),
                'extratitleclasses' => array($this, 'blockD41d8cd98f00b204e9800998ecf8427e'),
                'startday' => array($this, 'blockE052079a625ca42b568ba24af19cc7eb'),
                'endday' => array($this, 'blockCea7eb43b2813988eae06d16e48e891d'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= '        ';
        if ($parent = $this->mustache->loadPartial('block_myoverview/event-list-group')) {
            $context->pushBlockContext(array(
                'title' => array($this, 'block0f83c405c18f64e68ad4fe7253cc9942'),
                'extratitleclasses' => array($this, 'blockD41d8cd98f00b204e9800998ecf8427e'),
                'startday' => array($this, 'blockCea7eb43b2813988eae06d16e48e891d'),
                'endday' => array($this, 'block28496b40d26042aab6f3e0806a415f72'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= '        ';
        if ($parent = $this->mustache->loadPartial('block_myoverview/event-list-group')) {
            $context->pushBlockContext(array(
                'title' => array($this, 'blockC0793e31d2c3d60c77c996977e673ed1'),
                'extratitleclasses' => array($this, 'blockD41d8cd98f00b204e9800998ecf8427e'),
                'startday' => array($this, 'block28496b40d26042aab6f3e0806a415f72'),
                'endday' => array($this, 'blockD41d8cd98f00b204e9800998ecf8427e'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $buffer .= '
';
        $buffer .= $indent . '        <div class="text-xs-center text-center m-y-2">
';
        $buffer .= $indent . '            <button type="button" class="btn btn-secondary" data-action="view-more">
';
        $buffer .= $indent . '                ';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->sectionA388aafb75ee9aec4522d37f229d9134($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                <span class="hidden" data-region="loading-icon-container">
';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context, $indent . '                    ');
        }
        $buffer .= $indent . '                </span>
';
        $buffer .= $indent . '            </button>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '    <div class="hidden text-xs-center text-center m-t-3" data-region="empty-message">
';
        $buffer .= $indent . '        <img class="empty-placeholder-image-lg"
';
        $buffer .= $indent . '             src="';
        $value = $this->resolveValue($context->findDot('urls.noevents'), $context);
        $buffer .= call_user_func($this->mustache->getEscape(), $value);
        $buffer .= '"
';
        $buffer .= $indent . '             alt="';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section8f4508ae91ef39d3e7112df52d067a96($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '             role="presentation">
';
        $buffer .= $indent . '        <p class="text-muted m-t-1">';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section8f4508ae91ef39d3e7112df52d067a96($context, $indent, $value);
        $buffer .= '</p>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        // 'js' section
        $value = $context->find('js');
        $buffer .= $this->section70e2c73c3dd17ce4895cbb3aa07a8994($context, $indent, $value);

        return $buffer;
    }

    private function section6b7765e49752a0033b4ce936e4f548bd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' recentlyoverdue, block_myoverview ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' recentlyoverdue, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4e3d0118d9508a09db0617bcf04570b2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' today ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' today ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8e82bfb59e7d3787bb44e2915ab8a252(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' next7days, block_myoverview ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' next7days, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section64126662ba806010592fa1f2d0df867f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' next30days, block_myoverview ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' next30days, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section73e2d31fbcff71568286bba0816b9728(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' future, block_myoverview ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' future, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionA388aafb75ee9aec4522d37f229d9134(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' viewmore ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' viewmore ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8f4508ae91ef39d3e7112df52d067a96(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' noevents, block_myoverview ';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' noevents, block_myoverview ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section70e2c73c3dd17ce4895cbb3aa07a8994(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'jquery\', \'block_myoverview/event_list\'], function($, EventList) {
    var root = $("#event-list-container-{{$courseid}}{{/courseid}}");
    EventList.registerEventListeners(root);
});
';
            $result = call_user_func($value, $source, $this->lambdaHelper);
            if (strpos($result, '{{') === false) {
                $buffer .= $result;
            } else {
                $buffer .= $this->mustache
                    ->loadLambda((string) $result)
                    ->renderInternal($context);
            }
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require([\'jquery\', \'block_myoverview/event_list\'], function($, EventList) {
';
                $buffer .= $indent . '    var root = $("#event-list-container-';
                $blockFunction = $context->findInBlock('courseid');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                }
                $buffer .= '");
';
                $buffer .= $indent . '    EventList.registerEventListeners(root);
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function blockEa4a9f0731767159e863e1db7e72336d($context)
    {
        $indent = $buffer = '';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section6b7765e49752a0033b4ce936e4f548bd($context, $indent, $value);
    
        return $buffer;
    }

    public function block38999efb548e1543b72f05033be446fd($context)
    {
        $indent = $buffer = '';
        $buffer .= 'text-danger';
    
        return $buffer;
    }

    public function blockEa230cf4d288c3881a266d7b3094d7c5($context)
    {
        $indent = $buffer = '';
        $buffer .= '-14';
    
        return $buffer;
    }

    public function blockE13f09ec51e6aa10c3789885dab1c67f($context)
    {
        $indent = $buffer = '';
        $buffer .= '0';
    
        return $buffer;
    }

    public function block06df5a9d0e1d780d3c87f4275a8bcb47($context)
    {
        $indent = $buffer = '';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section4e3d0118d9508a09db0617bcf04570b2($context, $indent, $value);
    
        return $buffer;
    }

    public function blockD41d8cd98f00b204e9800998ecf8427e($context)
    {
        $indent = $buffer = '';
    
        return $buffer;
    }

    public function blockE052079a625ca42b568ba24af19cc7eb($context)
    {
        $indent = $buffer = '';
        $buffer .= '1';
    
        return $buffer;
    }

    public function block57cf602548cea5271a14e50954788621($context)
    {
        $indent = $buffer = '';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section8e82bfb59e7d3787bb44e2915ab8a252($context, $indent, $value);
    
        return $buffer;
    }

    public function blockCea7eb43b2813988eae06d16e48e891d($context)
    {
        $indent = $buffer = '';
        $buffer .= '7';
    
        return $buffer;
    }

    public function block0f83c405c18f64e68ad4fe7253cc9942($context)
    {
        $indent = $buffer = '';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section64126662ba806010592fa1f2d0df867f($context, $indent, $value);
    
        return $buffer;
    }

    public function block28496b40d26042aab6f3e0806a415f72($context)
    {
        $indent = $buffer = '';
        $buffer .= '30';
    
        return $buffer;
    }

    public function blockC0793e31d2c3d60c77c996977e673ed1($context)
    {
        $indent = $buffer = '';
        // 'str' section
        $value = $context->find('str');
        $buffer .= $this->section73e2d31fbcff71568286bba0816b9728($context, $indent, $value);
    
        return $buffer;
    }
}
