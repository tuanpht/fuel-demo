<?php echo Form::open(array("class"=>"form-horizontal")); ?>

    <fieldset>
        <div class="form-group">
            <?php echo Form::label('Name', 'name', array('class'=>'control-label')); ?>

                <?php echo Form::input('name', Input::post('name', isset($user) ? $user->name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Name')); ?>

        </div>
        <div class="form-group">
            <?php echo Form::label('Email', 'email', array('class'=>'control-label')); ?>

                <?php echo Form::input('email', Input::post('email', isset($user) ? $user->email : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Email')); ?>

        </div>
        <div class="form-group">
            <?php echo Form::label('Password', 'password', array('class'=>'control-label')); ?>

                <?php echo Form::password('password', '', array('class' => 'col-md-4 form-control', 'placeholder'=>'Password')); ?>

        </div>
        <div class="form-group">
            <?php echo Form::label('Confirm Password', 'confirm_password', array('class'=>'control-label')); ?>

                <?php echo Form::password('confirm_password', '', array('class' => 'col-md-4 form-control', 'placeholder'=>'Password')); ?>

        </div>
        <div class="form-group">
            <label class='control-label'>&nbsp;</label>
            <?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
    </fieldset>
<?php echo Form::close(); ?>