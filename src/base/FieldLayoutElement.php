<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\base;

use craft\helpers\StringHelper;
use craft\models\FieldLayout;
use yii\base\ArrayableTrait;
use yii\base\BaseObject;

/**
 * FieldLayoutElement is the base class for classes representing field layout elements in terms of objects.
 *
 * @property FieldLayout $layout The layout this element belongs to
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.5.0
 */
abstract class FieldLayoutElement extends BaseObject
{
    use ArrayableTrait {
        fields as baseFields;
    }

    /**
     * @var int The width (%) of the field
     */
    public int $width = 100;

    /**
     * @var string The UUID of the layout element.
     * @since 4.0.0
     */
    public string $uid;

    /**
     * @var FieldLayout The field layout tab this element belongs to
     * @see getLayout()
     * @see setLayout()
     */
    private FieldLayout $_layout;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!isset($this->uid)) {
            $this->uid = StringHelper::UUID();
        }
    }

    /**
     * Returns the layout this element belongs to.
     *
     * @return FieldLayout
     * @since 4.0.0
     */
    public function getLayout(): FieldLayout
    {
        return $this->_layout;
    }

    /**
     * Sets the layout this element belongs to.
     *
     * @param FieldLayout $layout
     * @since 4.0.0
     */
    public function setLayout(FieldLayout $layout): void
    {
        $this->_layout = $layout;
    }

    /**
     * @inheritdoc
     */
    public function fields(): array
    {
        $fields = $this->baseFields();
        if (!$this->hasCustomWidth()) {
            unset($fields['width']);
        }
        return $fields;
    }

    /**
     * Returns whether the element can have a custom width.
     *
     * @return bool
     */
    public function hasCustomWidth(): bool
    {
        return false;
    }

    /**
     * Returns the selector HTML that should be displayed within field layout designers.
     *
     * @return string
     */
    abstract public function selectorHtml(): string;

    /**
     * Returns the settings HTML for the layout element.
     *
     * @return string|null
     */
    public function settingsHtml(): ?string
    {
        return null;
    }

    /**
     * Returns the element’s form HTMl.
     *
     * Return `null` if the element should not be present within the form.
     *
     * @param ElementInterface|null $element The element the form is being rendered for
     * @param bool $static Whether the form should be static (non-interactive)
     * @return string|null
     */
    abstract public function formHtml(?ElementInterface $element = null, bool $static = false): ?string;

    /**
     * Returns the element container HTML attributes.
     *
     * @param ElementInterface|null $element The element the form is being rendered for
     * @param bool $static Whether the form should be static (non-interactive)
     * @return array
     */
    protected function containerAttributes(?ElementInterface $element = null, bool $static = false): array
    {
        $attributes = [];
        if ($this->hasCustomWidth()) {
            $attributes['class'][] = 'width-' . ($this->width ?? 100);
        }
        return $attributes;
    }
}
