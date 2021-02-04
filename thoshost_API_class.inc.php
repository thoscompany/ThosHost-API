<?php
/**
* Thos-Host integration PHP class.
* @link thos-host.com
* @author THOS-SOFTWARES LTD.
* @since 03/02/2021
*
**/
class TH_API
{
	var $API_KEY = '';
	var $API_PASSWORD = '';
	var $init = false;
	function __construct(string $API_KEY, string $API_PASSWORD)
	{
		if(empty($API_KEY))
		{
			$this->init = false;
			$answer = json_encode(array('status' => 'FALSE', 'answer' => 'API key parameter cannot be empty.'));
			return $answer;
		}
		else if(empty($API_PASSWORD))
		{
			$this->init = false;
			$answer = json_encode(array('status' => 'FALSE', 'answer' => 'API password parameter cannot be empty.'));
			return $answer;
		}
		else
		{
			$checkAPI = $this->call_API('init', array('API_KEY' => $API_KEY, 'API_PASSWORD' => $API_PASSWORD);
			$api_call_status = json_decode($checkAPI, true);
			if($checkAPI['status'] == 'OK')
			{
				$this->init = true;
				$this->API_KEY = $API_KEY;
				$this->API_PASSWORD = $API_PASSWORD;
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	function call_API(string $CMD = 'getAccount', array $POST = array())
	{
		if($this->init && $CMD != 'init')
		{
			$api_array = array('API_KEY' => $this->API_KEY, 'API_PASSWORD' => $this->API_PASSWORD);
			$POST = array_merge($api_array, $POST)
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://thos-host.com/hooks/v1/'.$CMD);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			if(!empty($POST)){
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($POST));
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$response = curl_exec($ch);		
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpCode == 404) {
			    $answer = json_encode(array('status' => 'cUrlError', 'answer' => 'The required call is not existing or has been removed.'));
				return $answer;
			}
			curl_close($ch);
			if(empty($response)){
				$answer = json_encode(array('status' => 'FALSE', 'answer' => 'The returned answer is empty.'));
				return $answer;
			}
			else
			{
				return $response;
			}
		}
		else
		{
			if($CMD == 'init')
			{
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://thos-host.com/hooks/v1/init');
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
				if(!empty($post)){
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
				}
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$response = curl_exec($ch);		
				curl_close($ch);
				if(empty($response)){
					$answer = json_encode(array('status' => 'FALSE', 'answer' => 'The returned answer is empty.'));
					return $answer;
				}
				else
				{
					return $response;
				}
			}
			else
			{
				$answer = json_encode(array('status' => 'FALSE', 'answer' => 'The call hasn\'t been initiated yet.'));
					return $answer;
			}
		}
	}
	function p(array $print = array('status' => 'FALSE', 'answer' => 'No array parameter found on "p" function for printing arrays.'))
	{
		// print an array
		echo '<pre>'.print_r($print, true).'</pre>';
	}
	function getAccount()
	{
		// get account information
		$this->call_API('getAccount');
	}
	function getCurrency()
	{
		// get ThosHost product currency
		$this->call_API('getCurrency');
	}
	function setAccountInfo(array $data = null)
	{
		/**
		* set account information, valid parameters
		* "email"
		* "username"
		* "password"
		* "age"
		* "2fa" (2 factor authentication)
		* "newsletter_status" (account newsletter subscribe status)
		* "zip" (zip / postal code of account)
		* "real_name" (real name)
		* "address"
		* "company"
		* "country"
		* "state"
		* "city"
		* "phone_number"
		**/
		$this->call_API('setAccountInfo', $data);
	}
	function placeOrder(int $product_id = -1)
	{
		$this->call_API('placeOrder', array('product_id' => (int)$product_id));
	}
	function getAccountServices()
	{
		$this->call_API('getAccountServices');
	}
	function getAccountDomains()
	{
		$this->call_API('getAccountDomains');
	}
	function requestCancelation(int $service_id = -1)
	{
		$this->call_API('requestCancelation', array('service_id' => (int)$service_id));
	}
	function getCancelationStatus(int $service_id = -1)
	{
		$this->call_API('getCancelationStatus', array('service_id' => (int)$service_id));
	}
	function removeCancelation(int $service_id = -1)
	{
		$this->call_API('removeCancelation', array('service_id' => (int)$service_id));
	}
	function pushService(int $service_id = -1, string $to_email)
	{
		$this->call_API('pushService', array('service_id' => (int)$service_id, 'to' => $to_email));
	}
	function enableAutomaticRenewal(int $service_id = -1)
	{
		$this->call_API('enableAutomaticRenewal', array('service_id' => (int)$service_id));
	}
	function disableAutomaticRenewal(int $service_id = -1)
	{
		$this->call_API('disableAutomaticRenewal', array('service_id' => (int)$service_id));
	}
	function renewService(int $service_id = -1)
	{
		$this->call_API('renewService', array('service_id' => (int)$service_id));
	}
	function submitDomainTransferRequest(int $service_id = -1, string $transfer_code)
	{
		$this->call_API('submitDomainTransferRequest', array('service_id' => (int)$service_id), 'transfer_code' => $transfer_code);
	}
	function checkRegistered(string $domain)
	{
		$this->call_API('checkRegistered', array('domain' => $domain));
	}
	function getNameservers(string $domain)
	{
		$this->call_API('getNameservers', array('domain' => $domain));
	}
	function getWHOIS(string $domain)
	{
		$this->call_API('getWHOIS', array('domain' => $domain));
	}
	function getContact(string $domain)
	{
		$this->call_API('getContact', array('domain' => $domain));
	}
	function registerDomain(string $domain)
	{
		$this->call_API('registerDomain', array('domain' => $domain));
	}
	function setNameservers(string $domain, array $nameservers)
	{
		/**
		* Example value for $nameservers:
		* array('ns1.thos-host.com', 'ns2.thos-host.com')
		**/
		$this->call_API('registerDomain', array('domain' => $domain, $nameservers));
	}
	function getContact(string $domain, string $transfer_code)
	{
		$this->call_API('getContact', array('domain' => $domain, array('transfer_code' => $transfer_code)));
	}
	function getVPSInfo(int $vps_id = -1)
	{
		// get VPS information
		$this->call_API('getVPSInfo', array('vps_id' => $vps_id));
	}
	function getVPSOSList(int $vps_id = -1)
	{
		// get VPS available OS list
		$this->call_API('getVPSOSList', array('vps_id' => $vps_id));
	}
	function getVPSLocations(int $vps_id = -1)
	{
		// get VPS available locations
		$this->call_API('getVPSLocations', array('vps_id' => $vps_id));
	}
	function bootVPS(int $vps_id = -1)
	{
		// boot VPS
		$this->call_API('bootVPS', array('vps_id' => $vps_id));
	}
	function shutdownVPS(int $vps_id = -1)
	{
		// shutdown VPS
		$this->call_API('shutdownVPS', array('vps_id' => $vps_id));
	}
	function getVNCVPS(int $vps_id = -1)
	{
		// get VPS VNC credentials
		$this->call_API('getVNCVPS', array('vps_id' => $vps_id));
	}
	function setVNCVPSPassword(int $vps_id = -1, string $vnc_password)
	{
		// set VPS VNC password
		$this->call_API('setVNCVPSPassword', array('vps_id' => $vps_id, 'password' => $vnc_password));
	}
	function setVPSHostname(int $vps_id = -1, string $hostname)
	{
		// set VPS hostname
		$this->call_API('setVPSHostname', array('vps_id' => $vps_id, 'password' => $hostname));
	}
	function restartVPS(int $vps_id = -1)
	{
		// restart VPS
		$this->call_API('restartVPS', array('vps_id' => $vps_id));
	}
	function reinstallVPS(int $vps_id = -1, int $template_id)
	{
		// reinstall VPS
		$this->call_API('reinstallVPS', array('vps_id' => $vps_id, 'template_id' => $template_id));
	}
	function mountVPSISO(int $vps_id = -1, string $iso)
	{
		// mount VPS ISO image (list of ISO images can be found on "getVPSInfo(int $vps_id)" call)
		$this->call_API('mountVPSISO', array('vps_id' => $vps_id, 'iso' => $iso));
	}
	function unmountVPSISO(int $vps_id = -1)
	{
		// unmount VPS ISO image
		$this->call_API('unmountVPSISO', array('vps_id' => $vps_id));
	}
	function getDedicatedServerInfo(int $dedicated_server_id = -1)
	{
		// get dedicated server information
		$this->call_API('getDedicatedServerInfo', array('dedicated_server_id' => $dedicated_server_id));
	}
	function rebootDedicatedServer(int $dedicated_server_id = -1)
	{
		// get dedicated server information
		$this->call_API('rebootDedicatedServer', array('dedicated_server_id' => $dedicated_server_id));
	}
	function reinstallDedicatedServer(int $dedicated_server_id = -1, array $new_info)
	{
		/**
		* Example value for $new_info:
		* array('hostname' => 'newHostname', 'user' => 'thoshost', 'password' => '6492Ajgir')
		* You can use only alphanumeric characters
		**/
		$dedi_array = array('dedicated_server_id' => $dedicated_server_id);
		$info_final = array_merge($dedi_array, $new_info);
		$this->call_API('reinstallDedicatedServer', $info_final);
	}
	function setRDNS(int $dedicated_server_id = -1, string $rDNS)
	{
		// set dedicated server rDNS
		$this->call_API('rebootDedicatedServer', array('dedicated_server_id' => $dedicated_server_id, 'rDNS' => $rDNS));
	}
	function setHostname(int $dedicated_server_id = -1, string $hostname)
	{
		// set dedicated server hostname
		$this->call_API('setHostname', array('dedicated_server_id' => $dedicated_server_id, 'hostname' => $hostname));
	}
	function setPassword(int $dedicated_server_id = -1, string $password)
	{
		// set dedicated server password
		$this->call_API('setHostname', array('dedicated_server_id' => $dedicated_server_id, 'password' => $password));
	}
	/* v ONLY FOR DEDIRESELLER & PARTNER PROGRAM MEMBERS v */
	function getTickets()
	{
		// get account tickets
		$this->call_API('getTickets');
	}
	function getTicketInfo(int $ticket_id)
	{
		// get specific ticket info
		$this->call_API('getTicketInfo', array('ticket_id' => $ticket_id));
	}
	function getTicketDepartments()
	{
		// get specific ticket info
		$this->call_API('getTicketDepartments');
	}
	function openTicket(int $service_id = -1, int $department_id = -1, string $subject = 'New ticket', string $message)
	{
		// open a ticket
		$this->call_API('openTicket', array('service_id' => $service_id, 'department_id' => $department_id, $subject, 'message' => $message));
	}
	function replyTicket(int $ticket_id, string $message, bool $close = false)
	{
		// answer to a ticket
		$this->call_API('replyTicket', array('ticket_id' => $ticket_id, 'message' => $message, 'close' => $close));
	}
}