<?php echo validation_errors() ?>

<div>
    <?php
        $data = array(
            'name' => 'date',
            'value' => '',
            'id'=> 'date',
            'readonly' => 'readonly'
        );
        echo form_label('Date', 'date');
        echo form_input($data);
    ?>
</div>
<div>
    <?php
        $data = array(
            'es' => 'Spanish',
            'en' => 'English',
            'all' => 'Both'
        );
        echo form_label('Language', 'lang');
        echo form_dropdown('lang', $data, set_value('lang'));
    ?>
</div>
<div>
    <?php echo form_label('Title in Spanish', 'title_es') ?>
    <?php echo form_input('title_es', set_value('title_es'), array('class' => form_error('title_es') ? 'error' : 'ok')) ?>
</div>
<div>
    <?php echo form_label('Title in English', 'title_en') ?>
    <?php echo form_input('title_en', set_value('title_en')) ?>
</div>
<div>
    <?php
        $data = array(
            'name' => 'content_es',
            'value' => set_value('content_es'),
            'id'=> 'content_es'
        );
        echo form_label('Content in Spanish', 'content_es');
        echo form_textarea($data);
    ?>
</div>
<div>
    <?php
        $data = array(
            'name' => 'content_en',
            'value' => set_value('content_en'),
            'id'=> 'content_en'
        );
        echo form_label('Content in English', 'content_en');
        echo form_textarea($data);
    ?>
</div>
<div>
    <?php
        $data = array(
            'type'          => 'submit',
            'content'       => 'Save'
        );
        echo form_button($data);
    ?>
</div>

<?php echo form_close()?>
