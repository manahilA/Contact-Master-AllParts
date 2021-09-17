<?php

    $inData = getRequestInfo();
    
    $email = $inData["email"];
    $firstName = $inData["firstName"];
    $lastName = $inData["lastName"];
    $phoneNumber = $inData["phoneNumber"];
    $fullName = $firstName;
    $fullName .= " ";
    $fullName .= $lastName;

    // connect to server
    $conn = new mysqli("localhost", "superUser", "Hack34", "ContactManager");
    if ($conn->connect_error)
    {
        returnWithError( $conn->connect_error );
    }

    else
    {
        $sql = "UPDATE Contacts SET firstname = '" . $firstName . "', lastName = '" . $lastName . "', phoneNumber = '" . $phoneNumber . "', email = '" . $email . "', fullName = '" . $fullName . "'";

        // Check if update was unsuccessful
        if( $result = $conn->query($sql) != TRUE )
        {
            returnWithError( $conn->error );
        }


        $conn->close();
    }

    returnWithError("");

    function getRequestInfo()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    function sendResultInfoAsJson( $obj )
    {
        header('Content-type: application/json');
        echo $obj;
    }

    function returnWithError( $err )
    {
        $retValue = '{"error":"' . $err . '"}';
        sendResultInfoAsJson( $retValue );
    }

    function returnWithInfo($firstName, $lastName, $email, $phoneNumber)
    {
        $retValue = '{"firstName":"' . $firstName . '","lastName":"' . $lastName . '","email":' . $email . ',"phoneNumber":' . $phoneNumber . ',"error":""}';
        sendResultInfoAsJson( $retValue );
    }

?>
