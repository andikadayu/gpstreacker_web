<?php
    class API_KEYS{
        private $api_list = array(
            "bzqVHFf7sMR03gjkGGH1tIhhIh5DaZA3",
            "dQq2BS86Or5QlHmlkw0C0rmO8biuUDk5",
            "wco5wkEiVpZumrSru50vZ1imk6knrgMh",
            "9olXRUHqz8Num8qSIxB7pej7NTWwIqrE",
            "vYfdVUAi9TA2pvuaDNTCboQY7wDONgZk",
            "d5UGP39aF8qJuXrLsP3DpsCVNNiHmxJ4",
            "pv2A0M0C6NbfoQNF0lQ0QRyNRuTnWVQK",
            "wl7MShi7IMWotMoa6vzYDFiXD4PZFbwN"
        );

        public function check_api($keys){

            if(in_array($keys,$this->api_list)){
                return "OK";
            }else{
                return "ERROR";
            }
        }

        
    }

?>