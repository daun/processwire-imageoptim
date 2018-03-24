<?php namespace ProcessWire;

class ImageOptimConfig extends ModuleConfig {

    const FILE_USAGE = 'USAGE.md';

    public function getDefaults() {
        return array(
            'username'          => '',
            'quality'            => 'medium',
            'format_settings'    => '',
            'file_suffix'        => 'optim',
            'auto_optimize'      => 0,
            'optimize_original'  => 0,
            'replace_crops'      => 0,
            'async'              => 0,
            'no_temp_image'      => 0,
            'logging'            => 0,
        );
    }

    public function getInputfields() {
        $inputfields = parent::getInputfields();

        $defaults = $this->getDefaults();
        $data = array_merge($this->getDefaults(), $this->modules->getConfig('ImageOptim'));

        // Field: Information

        $field = wire('modules')->get('InputfieldMarkup');
        $field->label = $this->_('Information');
        $field->description = $this->_('This module is a helper module for [ImageOptim](https://imageoptim.com), a service that compresses and optimizes your images in the cloud. Please refer to their site for [API details](https://imageoptim.com/api) and [pricing information](https://imageoptim.com/api/pricing).');
        $field->icon = 'info';
        $inputfields->add($field);

        // Field: Usage

        // Read usage info from markdown file
        $usage = file_get_contents(__DIR__ . '/' . self::FILE_USAGE);
        // Fix RegEx issues with Mac linefeeds
        $usage = preg_replace('/(\r\n|\n|\r)/', "\n", $usage);
        // Make headers smaller and bold in markup
        $usage = preg_replace('/^[#](.+?)$/m', '#### ** $1 **', $usage);

        if ($usage) {
            $field = wire('modules')->get('InputfieldMarkup');
            $field->label = $this->_('Usage');
            $field->description = $usage;
            $field->textFormat = Inputfield::textFormatMarkdown;
            $field->prependMarkup = '<div style="max-width: 53em;">';
            $field->appendMarkup = '</div>';
            $field->collapsed = Inputfield::collapsedYes;
            $field->icon = 'code';

            $inputfields->add($field);
        }


        // Field: ImageOptim username

        $field = wire('modules')->get('InputfieldText');
        $field->name = 'username';
        $field->label = $this->_('ImageOptim username');
        $field->icon = 'key';
        $field->required = true;

        if (!$data['username']) {
            $field->notes .= $this->_("Your username can be found in the [ImageOptim dashboard](https://imageoptim.com/api/dash). If you don't have a username, [sign up for an account](https://imageoptim.com/api/register).");
        }
        else {
            $field->notes .= $this->_("Open the [ImageOptim dashboard](https://imageoptim.com/api/dash) to manage your subscription and get compression stats.");
        }

        $inputfields->add($field);

        // Config if username set

        if ($data['username']) {

            // Fieldset: ImageOptim settings

            $fieldset = wire('modules')->get('InputfieldFieldset');
            $fieldset->label = $this->_("Compression settings");
            $fieldset->description = $this->_("Please refer to the [ImageOptim docs](https://imageoptim.com/api/post#options) for details on these settings.");
            $fieldset->icon = 'sliders';
            $inputfields->add($fieldset);

                // Field: Quality

                $field = wire('modules')->get('InputfieldSelect');
                $field->name = 'quality';
                $field->label = $this->_('Quality');
                $field->required = true;
                $field->icon = 'qrcode';
                $field->addOption('low', $this->_('Low (smallest possible size, visible artefacts)'));
                $field->addOption('medium', $this->_('Medium (small files, barely noticable artefacts)'));
                $field->addOption('high', $this->_('High (larger files, no visible artefacts)'));
                $field->addOption('lossless', $this->_('Lossless (no compression)'));

                $fieldset->add($field);

                // Field: Compression settings overwrite

                $field = wire('modules')->get('InputfieldTextarea');
                $field->name = 'format_settings';
                $field->label = $this->_('Settings by image type');
                $field->description = $this->_('You can set [compression options](https://imageoptim.com/api/post#options) for different image types. Add one config per line, e.g.  ') . PHP_EOL .
                                      '`jpg,jpeg: quality=medium`  ' . PHP_EOL .
                                      '`png: quality=low,2x`';
                $field->notes = $this->_('**Please note**: if set, this will not overwrite the above global quality setting, but replace it. Image types not in this list will **not** be optimized. To make sure all images get optimized, either a) use the global quality setting only or b) make sure every image type has optimization settings configured.');
                $field->rows = 4;
                $field->icon = 'file-text-o';
                $field->collapsed = Inputfield::collapsedBlank;

                $fieldset->add($field);

            // Fieldset: Module behaviour

            $fieldset = wire('modules')->get('InputfieldFieldset');
            $fieldset->label = $this->_("Module behaviour");
            $fieldset->icon = 'gear';
            $inputfields->add($fieldset);

                // Field: File suffix

                $field = wire('modules')->get('InputfieldText');
                $field->name = 'file_suffix';
                $field->label = $this->_('Optimized image suffix');
                $field->description = sprintf($this->_("This will be appended to the original image's filename to mark it as an optimized variation: *original-filename.%s.jpg*"), $data['file_suffix']);
                $field->required = true;
                $field->icon = 'files-o';

                if ($data['file_suffix'] === $defaults['file_suffix']) {
                    $field->collapsed = Inputfield::collapsedYes;
                }

                $fieldset->add($field);

                // Field: Auto-optimization

                $field = wire('modules')->get('InputfieldCheckbox');
                $field->name = 'auto_optimize';
                $field->label = $this->_('Automatically optimize image variations on resize');
                $field->description = $this->_('If checked, every image will be optimized automatically when being resized. You will not have to use the `optimize()` method in this case.  ') . PHP_EOL .
                                      $this->_("To disable optimization for single images, pass `optimize => false` as image sizer options: ") .
                                      "`\$image->size(400, 0, ['optimize' => false])`";
                $field->icon = 'magic';
                $field->collapsed = Inputfield::collapsedBlank;

                $fieldset->add($field);

                /*
                 * Not yet implemented
                 *
                 *

                // Field: Async processing

                $field = wire('modules')->get('InputfieldCheckbox');
                $field->name = 'async';
                $field->label = $this->_('Process images asynchronously');
                $field->description = $this->_("If checked, images will be processed asynchronously. Until images are optimized, a temporary image will be displayed. This will speed up page load and avoid time-outs. **Please note:** This option will **not** work on ProCache installations or similar cache setups that store output as rendered HTML. At least one PHP call on any site has to be made in order to activate the module and overwrite the temporary images.");
                $field->icon = 'refresh';
                $field->collapsed = Inputfield::collapsedBlank;

                $fieldset->add($field);

                // Field: Disable temp images when processing async

                $field = wire('modules')->get('InputfieldCheckbox');
                $field->name = 'no_temp_image';
                $field->label = $this->_('Disable temporary images');
                $field->description = $this->_("If checked, no temporary images will be created while the images are in ImageOptim's queue. Recommended if you have large galleries.");
                $field->icon = 'picture-o';
                $field->showIf = 'async=1';

                $fieldset->add($field);

                // Field: Replace CropImage crops

                if (class_exists('FieldtypeCropImage')) {
                    $field = wire('modules')->get('InputfieldCheckbox');
                    $field->name = 'replace_crops';
                    $field->label = $this->_('Replace CropImages');
                    $field->description = $this->_('If checked, ImageOptim will automatically replace every image file generated by CropImage with an optimized version.');
                    $field->icon = 'fa-fire';
                    $field->collapsed = Inputfield::collapsedBlank;

                    $fieldset->add($field);
                }

                */

                // Field: Logging

                $field = wire('modules')->get('InputfieldCheckbox');
                $field->name = 'logging';
                $field->label = $this->_('Verbose logging');
                $field->description = $this->_('This will write detailed compression data to a ProcessWire log file (path, size before, size after and savings). Errors will always be logged, regardless of this setting.');
                $field->icon = 'tree';
                $field->collapsed = Inputfield::collapsedBlank;

                $fieldset->add($field);
        }

        return $inputfields;
    }
}
