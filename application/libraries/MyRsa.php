<?php
/**
 *  这是用来进行rsa 加解密的函数
 *  author: church
 *  
 */
class MyRsa 
{
	
	//公钥
	public $public_key;
	
	//私钥
	public $private_key;
	
	//私钥文件路径
	public $private_key_path;
	
	//公钥文件路径
	public $public_key_path;
	
	//CI实例对象
	public $CI;
	
	public function __construct($path = '') 
	{
		if (!function_exists('openssl_public_encrypt')) {
			throw new Exception('openssl extension does not load');
		}
		
		$this->CI = & get_instance();
	}
	
	/**
	 *  初始化
	 */
	public function init($path = '') 
	{
		$this->set_path($path);
		$this->set_key();
	}
	
	/**
	 *  检查是否初始化
	 */
	public function check_init()
	{
		if (empty($this->public_key_path) || empty($this->private_key_path)) {
			throw new Exception('uninit');
		}
	}
	
	/**
	 *  设置公钥和私钥的路径
	 *  @param array $path
	 */
	public function set_path($path = '') 
	{
		
		if (!is_array($path) || !isset($path['private_key_path']) || !isset($path['public_key_path'])) {
			throw new Exception('invaild param');
		}
		
		
		$this->private_key_path = $path['private_key_path'];
		$this->public_key_path = $path['public_key_path'];
	}
	
	
	/**
	 *  存储公钥和私钥
	 *  
	 */
	public function set_key() 
	{
		
		if (!file_exists($this->public_key_path) || !file_exists($this->private_key_path)) {
			throw new Exception('invaild path');
		}
		
		
		$this->public_key = openssl_pkey_get_public($this->get_key($this->public_key_path));
		$this->private_key = openssl_pkey_get_private($this->get_key($this->private_key_path));
		
		if (!$this->public_key || !$this->private_key) {
			throw new Exception('key parameter is not a valid key');
		}
	}
	
	/**
	 *  读取公钥或私钥
	 */
	private function get_key($path) {
		
		$file_handle = fopen($path, 'r');
		$key = fread($file_handle, 8192);
		fclose($file_handle);
		
		return $key;
	}
	
	
	
	/**
	 *  使用公钥进行加密
	 *  @param mixed $data
	 */
	public function public_key_encrypt($data) 
	{
		$this->check_init();
		
		if (openssl_public_encrypt($data, $encrypted, $this->public_key)) {
			return $encrypted;
		} else {
			throw new Exception('encrypt failed');
		}
		
		
	}
	
	/**
	 *  使用私钥进行解密
	 *  @param mixed $data
	 */
	public function private_key_decrypt($data)
	{
		$this->check_init();
		
		if (openssl_private_decrypt($data, $decrypted, $this->private_key)) {
			return $decrypted;
		} else {
			throw new Exception('decrypt failed');
		}
	} 	

	/**
	 *  使用私钥进行签名
	 *  @param mixed $data
	 *  
	 */
	public function private_key_sign($data) 
	{
		$this->check_init();
		
		if (openssl_sign($data, $signature, $this->private_key, "sha1WithRSAEncryption")) {
			return $signature;
		} else {
			throw new Exception('signature failed');
		}
		
	}
	
	/**
	 *  使用公钥进行签名验证
	 *  @param array $data
	 */
	public function public_key_verify($data) 
	{
		$this->check_init();
		
		if (openssl_verify($data['data'], $data['signature'], $this->public_key, OPENSSL_ALGO_SHA1)) {
			return True;
		} else {
			throw new Exception('verify signature failed');
		}
	}

	
}
