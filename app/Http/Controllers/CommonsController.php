<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;


class CommonsController extends Controller {

    public function sendQuote(Request $request){
        $from_name = "PackersCity Quick Quote";
        $to='info@rensaki.com';

        // Handle Quick Quote
        if (
            empty($_REQUEST["name"]) ||
            empty($_REQUEST["email"]) || // (!filter_var($email, FILTER_VALIDATE_EMAIL)) ||
            empty($_REQUEST["moving_from"]) ||
            empty($_REQUEST["moving_to"]) ||
            empty($_REQUEST["phone"])
        ) {
            header("HTTP/1.1 401 Unauthorized");
            die();
        }

        $name = htmlentities(strip_tags($_REQUEST["name"]));
        $email = htmlentities(strip_tags($_REQUEST["email"]));
        $moving_from = htmlentities(strip_tags($_REQUEST["moving_from"]));
        $moving_to = htmlentities(strip_tags($_REQUEST["moving_to"]));
        $phone = htmlentities(strip_tags($_REQUEST["phone"]));

        $description = 'N/A';
        if(isset($_REQUEST['description'])) {
            $description = htmlentities(strip_tags($_REQUEST["description"]));
        }

        $subject = sprintf($from_name." from %s [%s]", $name, $email);

        $message="
        <table>
            <tr style='background-color: steelblue; color: white; vertical-align: middle;'>
                <td colspan=2>".$from_name."</h4></td>
            </tr>
            <tr>
                <td><strong>Name: </strong></td>
                <td>$name</td>
            </tr><tr>
                <td><strong>Email ID: </strong></td>
                <td>$email</td>
            </tr><tr>
                <td><strong>Mobile No.: </strong></td>
                <td>$phone</td>
            </tr><tr>
                <td><strong>Moving From: </strong></td>
                <td>$moving_from</td>
            </tr><tr>
                <td><strong>Moving To: </strong></td>
                <td>$moving_to</td>
            </tr><tr>
                <td><strong>Requirement: </strong></td>
                <td>$description
            </td></tr>
        </table>
        ";

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$from_name.' <info@packerscity.com>' . "\r\n";

        if(!mail($to, $subject, $message, $headers)) {
            header("HTTP/1.1 401 Unauthorized");
            return "There was an error while sending the email.";
        }

        return 'Thank You. We will get back to you within 24 hours.';
    }
}
