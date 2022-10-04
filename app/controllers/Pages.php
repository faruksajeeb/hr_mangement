<?php
class Pages extends CI_Controller {
 
    function search($search_terms = '')
    {
        // If the form has been submitted, rewrite the URL so that the search
        // terms can be passed as a parameter to the action. Note that there
        // are some issues with certain characters here.
        if ($this->input->post('q'))
        {
            redirect('/pages/search/' . $this->input->post('q'));
        }
 
        if ($search_terms)
        {
            // Load the model and perform the search
            $this->load->model('page_model');
            $results = $this->page_model->search($search_terms);
        }
 
        // Render the view, passing it the necessary data
        $this->load->view('reports/search_results', array(
            'search_terms' => $search_terms,
            'results' => @$results
        ));
    }
}
?>