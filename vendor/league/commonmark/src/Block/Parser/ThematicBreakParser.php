<?php

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * Original code based on the CommonMark JS reference parser (http://bitly.com/commonmark-js)
 *  - (c) John MacFarlane
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace League\CommonMark\Block\Parser;

use League\CommonMark\Block\Element\ThematicBreak;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Util\RegexHelper;

class ThematicBreakParser extends AbstractBlockParser
{
    /**
     * @param ContextInterface $context
     * @param Cursor           $cursor
     *
     * @return bool
     */
    public function parse(ContextInterface $context, Cursor $cursor)
    {
        if ($cursor->isIndented()) {
            return false;
        }

        $match = RegexHelper::matchAt(RegexHelper::getInstance()->getThematicBreakRegex(), $cursor->getLine(), $cursor->getFirstNonSpacePosition());
        if ($match === null) {
            return false;
        }

        // Advance to the end of the string, consuming the entire line (of the thematic break)
        $cursor->advanceBy(mb_strlen($cursor->getRemainder()));

        $context->addBlock(new ThematicBreak());
        $context->setBlocksParsed(true);

        return true;
    }
}
