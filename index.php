<?php
class Find_name{
    private $data_array;
    public function set_data($data){
        $this->data_array=$data;
    }
    public function get_data(){
        return $this->data_array;
    }
    //create a recusive function to find the oldest parent start with a name
    public function find_oldest_parent_name($name,&$oldest_name){
        if(isset($this->data_array[$name])){
            $parent_name=$this->data_array[$name];
            //echo $parent_name;
            $this->find_oldest_parent_name($parent_name,$oldest_name);
        }else{
            $oldest_name=$name;
            //echo 'find_name'.$name;

           
        }
    }
}
$data_array=[
    'david'=>'ionel',
    'ionel'=>'matei',
    'matei'=>'radu',
    'radu'=>'bogdan',
    'bogdan'=>'alex',
    'alex'=>'dan'
];
$find_name_object=new Find_name();
$find_name_object->set_data($data_array);
$name_oldest='';
 $find_name_object->find_oldest_parent_name('ionel',$name_oldest);
 echo $name_oldest;

?>
