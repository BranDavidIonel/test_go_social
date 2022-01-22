<?php
class Find_name
{
    private $data_array;
    public $result_name = '';
    public function set_data($data)
    {
        $this->data_array = $data;
    }
    public function add_node($name_soon, $name_parent)
    {
        $this->data_array[$name_soon] = $name_parent;
    }
    public function get_data()
    {
        return $this->data_array;
    }
    //create a recusive function to find the oldest parent start with a name
    public function find_oldest_parent_name($name)
    {
        if (isset($this->data_array[$name])) {
            $parent_name = $this->data_array[$name];
            $this->find_oldest_parent_name($parent_name);
        } else {
            $this->result_name = $name;
            //echo 'find_name' . $name;
        }
    }
}
session_start();
$find_name_object = new Find_name();
if (isset($_SESSION["all_data"])) {
    $find_name_object->set_data($_SESSION["all_data"]);
}


if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['name_soon']) && isset($_POST['name_parent'])) {
    if (isset($_SESSION["all_data"])) {
        $find_name_object->set_data($_SESSION["all_data"]);
    }
    $find_name_object->add_node($_POST['name_soon'], $_POST['name_parent']);
    $_SESSION["all_data"] = $find_name_object->get_data();
}
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['find_name'])) {
    $find_name_object->find_oldest_parent_name($_POST['find_name']);
}
if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['test_data'])) {
    $data_array = [
        'david' => 'ionel',
        'ionel' => 'matei',
        'matei' => 'radu',
        'radu' => 'bogdan',
        'bogdan' => 'alex',
        'alex' => 'dan'
    ];
    $find_name_object->set_data($data_array);

    $_SESSION["all_data"] = $find_name_object->get_data();
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h2> Add new </h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="formGroupExampleInput">Name Soon</label>
                    <input name="name_soon" type="text" class="form-control" id="formGroupExampleInput" placeholder="name soon..">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Name Parent</label>
                    <input name="name_parent" type="text" class="form-control" id="formGroupExampleInput2" placeholder="name parent..">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
            <form action="" method="post">
                <input type="submit" class="btn btn-primary" name="test_data" value="Add demo data" />
            </form>
        </div>
        <div class="col-md-4">
            <h2> Find </h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="formGroupExampleInput">Find start with name</label>
                    <input name="find_name" type="text" class="form-control" id="formGroupExampleInput" placeholder="name..">
                </div>
                <button type="submit" class="btn btn-primary">Find</button>
            </form>
        </div>
        <div class="col-md-4">
            <h1>The oldest name: <?php echo $find_name_object->result_name  ?></h1>
        </div>
    </div>
    <div class="row">
        <h2> All data </h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name Soon</th>
                    <th scope="col">Name Parent</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if ($find_name_object->get_data() != NULL) {
                        foreach ($find_name_object->get_data() as $key_soon_name => $parent_name) {
                            echo '<tr><td>' . $key_soon_name . '</td><td>' . $parent_name . '</td></tr>';
                        }
                    }
                    ?>
            </tbody>
        </table>
    </div>
</div>