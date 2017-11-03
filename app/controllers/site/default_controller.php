<?php

class default_controller extends Page {
        
    function __construct() {
        parent::__construct('site/default_page.php');
        $this->links->add(stylesheet("app/assets/css/page.css"));
    }
    
    function index($args) {
        $this->title = 'Home';
        $this->navtop = View::render('site/nav/navtop.php');
        $this->content = View::render('site/home/content.php');
        $this->footer = View::render('site/common/footer.php');
        $this->render();
    }
    
    function about($args) {
        $this->title = 'About Us';
        $this->navtop = View::render('site/nav/navtop.php');
        $this->content = View::render('site/about/content.php');
        $this->footer = View::render('site/common/footer.php');
        $this->render();
    }    
    
    function contact($args) {
        
        import('lib/forms/Form');
        $this->links->add(stylesheet("app/assets/css/forms.css"));
        
        $form = new Form('site/contact/frm_contact_us.php');
        
        $form->add('text', Form::text('text'));
        $form->add('checkbox', Form::checkbox('checkbox'));
        $form->add('combobox', Form::combobox('combobox', array( 'one'=>'one', 'two'=>'two', 'three'=>'three')));
        $form->add('file', Form::file('file'));
        $form->add('hidden', Form::hidden('hidden'));
        $form->add('password', Form::password('password'));
        $form->add('radio', Form::radio('radio', array( 'one'=>'1', 'two'=>'2', 'three'=>'3' )));
        $form->add('select', Form::select('select', array( 'one'=>'1', 'two'=>'2', 'three'=>'3' )));
        $form->add('textarea', Form::textarea('textarea'));
        
        $form->textarea->attributes->add('rows', '10');
        
        $form->text->rules->add(Rule::required());
        $form->text->sanitizers->add(Sanitize::sql());
        
        if (is_postback()) {
            $form->fill($_POST);
            $form->sanitize();
            $form->validate('<b style="color:green;">&check;</b>');            
        }
        
        $this->title = 'Contact Us';
        $this->navtop = View::render('site/nav/navtop.php');
        $this->content = $form;
        $this->footer = View::render('site/common/footer.php');
        $this->render();        
    }    
    
}
