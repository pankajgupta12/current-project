<?php @session_start();
/**
 * This provides a user-interface for using the DbDiff class.
 */
error_reporting(E_ALL);
require('config.php');
require_once('DbDiff.php');

//redirect on load if someone access directly without login
if( !isset($_SESSION['details']) )
{
	unset( $_SESSION['details'] );	
	$_SESSION = array();
	header( 'location:' . '/dbCmpr/index.php' );
}

//check logout
if( isset( $_REQUEST['act'] ) && $_REQUEST['act'] == 'logout' ) :
	
	unset( $_SESSION['details'] );
	$_SESSION = array();
	header( 'location:' . '/dbCmpr/index.php' );
	
endif;

if( isset($_SESSION['details']) )
{
	$getSessionDetails = json_decode($_SESSION['details']);
}

/**
 * Display options and instructions.
 *
 * @return void
 */
function show_options($dbs_config)
{
    echo '<h3> Export database schemas </h3>';

    if (count($dbs_config) > 0) {

        //echo '<p class="info">Select a database configuration from the list below, or select \'Enter details...\'</p>';

        echo '<ul id="db-list">';
        foreach ($dbs_config as $key => $db_config) {
            //echo '<li><a href="?a=export_schema&db=' . $key . '">' . $db_config['name'] . '</a></li>';
        }
        //echo '<li><em><a href="#" onclick="document.getElementById(\'db-config\').style.display=\'block\';return false;">Enter details...</a></em></li>';
        echo '</ul>';
    } else {

        echo '<p class="info">Enter connection details in the form below, or setup a database connection in the <code>config.php</code> file.</p>';
    }

    echo '<form action="?a=export_schema" method="post" id="db-config"' . (count($dbs_config) > 0 ? ' style="display:block;"' : '' ) . '>';
	
	//For First Schema database details
	
	echo '<h3><label for="schema1">For First database beta</label></h3>';
    echo '<div class="field"><label for="db-host">Beta</label><input type="text" name="db-host" id="db-host" value="localhost" /></div>';
    echo '<div class="field"><label for="db-user">User</label><input type="text" name="db-user" id="db-user" /></div>';
    echo '<div class="field"><label for="db-password">Password</label><input type="password" name="db-password" id="db-password" /></div>';
    echo '<div class="field"><label for="db-name">Database</label><input type="text" name="db-name" id="db-name" /></div>';
	echo  "<br>";
	//For Second Schema database details
    echo  "<br>";
	echo '<h3><label for="schema1">For Second database live</label></h3>';
    echo '<div class="field"><label for="db-host">Live</label><input type="text" name="db-host_2" id="db-host" value="localhost" /></div>';
    echo '<div class="field"><label for="db-user">User</label><input type="text" name="db-user_2" id="db-user" /></div>';
    echo '<div class="field"><label for="db-password">Password</label><input type="password" name="db-password_2" id="db-password" /></div>';
    echo '<div class="field"><label for="db-name">Database</label><input type="text" name="db-name_2" id="db-name" /></div>';
	
	
    echo '<div class="submit"><input type="submit" value="Export" /></div><div class="clearer"></div>';
    echo '</form>';

    /* echo '<h3>Step 2: Compare schemas</h3>';

    echo '<p class="info">Once two database schemas have been exported, paste them here to be compared.</p>';

    echo '<form action="?a=compare" method="post" id="compare">';
    if (count($dbs_config) < 2) {
        echo '<div class="field"><label for="schema1">First schema</label><textarea name="schema1" id="schema1" cols="100" rows="5"></textarea></div>';
        echo '<div class="field"><label for="schema2">Second schema</label><textarea name="schema2" id="schema2" cols="100" rows="5"></textarea></div>';
    } else {
        echo '<div class=""><label for="schema1">First schema</label><select name="schema1">';
        foreach ($dbs_config as $key => $db_config) {
            echo '<option value=' . $key . '>' . $db_config['name'] . '</option>';
        }
        echo '</select></div>';
        echo '<div class=""><label for="schema2">Second schema</label><select name="schema2">';
        foreach ($dbs_config as $key => $db_config) {
            echo '<option value=' . $key . '>' . $db_config['name'] . '</option>';
        }
        echo '</select></div>';
    }

    echo '<div class="submit"><input type="submit" value="Compare" /></div>';
    echo '</form>'; */
}

/**
 * Convenience method for outputting errors.
 *
 * @return void
 * */
function echo_error($error)
{
    echo '<p class="error">', $error, '</p>';
}

/**
 * Export the schema from the database specified and echo the results.
 *
 * @param string $db The key of the config to be extracted from $dbs_config.
 * @return void
 */
	function export_schema($config = null,$config_2 = null, $config = null)
	{
		$result = DbDiff::export($config['config'], $config['name']);
		$result2 = DbDiff::export($config_2['config'], $config_2['name_2']);

		//echo "<pre>"; print_r($result2); die;
		
		if ($result == null || $result2 == null) {
			echo_error('Couldn\'t connect to database: ' . mysql_error());
			return;
		}

		$serialized_schema = serialize($result);
		$serialized_schema2 = serialize($result2);
					   
	   do_compare($serialized_schema, $serialized_schema2,$config);
	   //echo '<p><a href="?">&laquo; Back to main page</a></p>';
	}

/**
 * Strips new line characters (CR and LF) from a string.
 *
 * @param string $str The string to process.
 * @return string The string without CRs or LFs.
 */
function strip_nl($str)
{
    return str_replace(array("\n", "\r"), '', $str);
}

/**
 * Returns an 's' character if the count is not 1.
 *
 * This is useful for adding plurals.
 *
 * @return string An 's' character or an empty string
 * */
function s($count)
{
    return $count != 1 ? 's' : '';
}

/**
 * Compare the two schemas and echo the results.
 *
 * @param string $schema1 The first schema (serialized).
 * @param string $schema2 The second schema (serialized).
 * @return void
 */
function do_compare($schema1 = null, $schema2 = null, $config = null)
{
    if (empty($schema1) || empty($schema2)) {
        echo_error('Both schemas must be given.');
        return;
    }
	
    $unserialized_schema1 = unserialize(strip_nl($schema1));
    $unserialized_schema2 = unserialize(strip_nl($schema2));
	
    $results = DbDiff::compare($unserialized_schema1, $unserialized_schema2, $config);
	
	if (!empty($results))
	{
		$results = json_decode($results);
		if( isset( $results->data->type ) )
		{
			echo '['. $results->data->message .']' . '::' . $results->data->type;
			echo '<p><a href="?">&laquo; Back to main page</a></p>';
		}
    }
	
	/*echo "<pre>";
	print_r($results);
	exit;*/
	
    /*  echo "<pre>";
    print_r($results); 
    
	if (count($results) > 0) {

        echo '<h3>Found differences in ' . count($results) . ' table' . s(count($results)) . ':</h3>';

        echo '<ul id="differences">';
        foreach ($results as $table_name => $differences) {

            echo '<li><strong>' . $table_name . '</strong><ul>';
            foreach ($differences as $difference) {
                echo '<li>' . $difference . '</li>';
            }
            echo '</ul></li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No differences found.</p>';
    }*/
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Database Comparator</title>
        <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
		<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    </head>
    <body>
	
	
        <div id="canvas">
            <h1><a href="?act=logout">Database Comparision <?php if( isset( $getSessionDetails->data->data->name ) ) print "  [ Welcome " . $getSessionDetails->data->data->name . " ] ";  ?></a></h1>
            <h2>Tool for comparing database schemas.</h2>
			
            <?php
            $action = @$_GET['a'];

            switch ($action) {

                case 'export_schema':

                    if (isset($_GET['db'])) {

                        $db = $_GET['db'];

                        if (!isset($dbs_config[$db])) {
                            echo_error('No database configuration selected.');
							echo '<p><a href="?">&laquo; Back to main page</a></p>';
                            break;
                        }

                        $config = $dbs_config[$db];
                    } else {

                        if (!isset($_POST['db-host']) || !isset($_POST['db-user']) || !isset($_POST['db-password']) || !isset($_POST['db-name'])) {
                            echo_error('No database configuration entered.');
							echo '<p><a href="?">&laquo; Back to main page</a></p>';
                            break;
                        }
						
						/*  if (!isset($_POST['db-host_2']) || !isset($_POST['db-user_2']) || !isset($_POST['db-password_2']) || !isset($_POST['db-name_2'])) {
                            echo_error('No database configuration entered for second schema.');
                            break;
                        } */

                        $config = array(
                            'name' => $_POST['db-name'],                            
                            'config' => array(
                                'host' => $_POST['db-host'],
                                'user' => $_POST['db-user'],
                                'password' => $_POST['db-password'],
                                'name' => $_POST['db-name']
                            )
                        );
						
						 $config_2 = array(
                            'name_2' => $_POST['db-name_2'],                            
                            'config' => array(
                                'host' => $_POST['db-host_2'],
                                'user' => $_POST['db-user_2'],
                                'password' => $_POST['db-password_2'],
                                'name' => $_POST['db-name_2']
                            )
                        );
                    }

                    export_schema($config,$config_2,$config);

                    //echo '<p><a href="?">&laquo; Back to main page</a></p>';
                    break;
               /*  case 'compare':
				
                    if (count($dbs_config) < 2) {
						
						
                        $schema1 = @$_POST['schema1'];
                        $schema2 = @$_POST['schema2'];
						
                        if (get_magic_quotes_gpc()) { // sigh...
                            $schema1 = stripslashes($schema1);
                            $schema2 = stripslashes($schema2);
                        }
						
                    } else {
                        $schema1 = $dbs_config[@$_POST['schema1']];
                        $schema2 = $dbs_config[@$_POST['schema2']];

						
						
						
                        $schema1 = serialize(DbDiff::export($schema1['config'], $schema1['name']));
                        $schema2 = serialize(DbDiff::export($schema2['config'], $schema2['name']));
                    }

                    do_compare($schema1, $schema2);

                    echo '<p><a href="?">&laquo; Back to main page</a></p>';
                    break; */
                default:
                    show_options($dbs_config);
            }
            ?>
            
        </div>
    </body>
</html>