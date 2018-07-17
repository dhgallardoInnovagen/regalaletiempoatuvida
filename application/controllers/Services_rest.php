 <?php

class Services_rest extends REST_Controller {

    function students_get() {
        $result =  new stdClass();
        $result->responseCode = 0;
        $result->responseMessage = 'Equipo encontrado';
        $result->student_data = 'nombre estudiante';

        $this->response($result, 200);
    }
    
    

}
