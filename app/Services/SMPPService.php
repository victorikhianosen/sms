<?php

namespace App\Services;

use Exception;

class SMPPService
{
    protected $host;
    protected $port;
    protected $username;
    protected $password;
    protected $socket;
    protected $sequence_number = 1;

    public function __construct()
    {
        $this->host = env('SMPP_HOST');
        $this->port = env('SMPP_PORT');
        $this->username = env('SMPP_USERNAME');
        $this->password = env('SMPP_PASSWORD');
    }

    /**
     * Connect to the SMPP server
     */
    public function connect()
    {
        $this->socket = fsockopen($this->host, $this->port);

        if (!$this->socket) {
            throw new Exception("Unable to connect to SMPP server");
        }
    }

    /**
     * Send a bind request to the SMPP server
     */
    public function bind()
    {
        $bind_request = $this->buildBindRequest();
        fwrite($this->socket, $bind_request);
        $response = fread($this->socket, 1024);

        // Check if the bind response is OK (0x00000000)
        $response_header = unpack('Ncommand_status', $response);
        if ($response_header['command_status'] !== 0) {
            throw new Exception("Bind failed with status: " . $response_header['command_status']);
        }
    }

    /**
     * Build the bind request (bind_transceiver PDU)
     */

    private function buildBindRequest()
    {
        $command_length = 0x001C;
        $command_id = 0x00000009;  // bind_transceiver
        $sequence_number = $this->sequence_number++;

        // Construct the bind request PDU
        $bind_request = pack('N', $command_length)
            . pack('N', $command_id)
            . pack('N', $sequence_number)
            . pack('A6', $this->username)      // system_id
            . pack('A8', $this->password)      // password
            . pack('C', 0)                     // system_type
            . pack('C', 0)                     // interface_version
            . pack('C', 0)                     // addr_ton
            . pack('C', 0)                     // addr_npi
            . pack('A21', '');                 // address_range (empty string)

        return $bind_request; // Make sure to return the bind request
    }


    /**
     * Send SMS via SMPP
     */
    public function sendSms($from, $to, $message)
    {
        $sms_request = $this->buildSmsRequest($from, $to, $message);
        fwrite($this->socket, $sms_request);
        $response = fread($this->socket, 1024);

        // Handle response here and check status
        $response_header = unpack('Ncommand_status', $response);
        if ($response_header['command_status'] !== 0) {
            throw new Exception("SMS send failed with status: " . $response_header['command_status']);
        }

        return true;
    }

    /**
     * Build the submit_sm request (PDU for sending SMS)
     */
    private function buildSmsRequest($from, $to, $message)
    {
        $command_length = 0x002C + strlen($message);
        $command_id = 0x00000004;  // submit_sm
        $sequence_number = $this->sequence_number++;

        // Construct the submit_sm PDU
        $sms_request = pack('N', $command_length)
            . pack('N', $command_id)
            . pack('N', $sequence_number)
            . pack('A11', $from)          // source_addr (sender)
            . pack('A11', $to)            // destination_addr (recipient)
            . pack('C', 0)                // esm_class
            . pack('C', 0)                // protocol_id
            . pack('C', 0)                // priority_flag
            . pack('C', 0)                // schedule_delivery_time
            . pack('C', 0)                // validity_period
            . pack('C', 0)                // registered_delivery
            . pack('C', 0)                // replace_if_present_flag
            . pack('C', 0)                // data_coding
            . pack('C', 0)                // sm_default_msg_id
            . pack('A', $message);        // short_message

        return $sms_request;
    }

    /**
     * Close the socket connection
     */
    public function close()
    {
        fclose($this->socket);
    }
}
