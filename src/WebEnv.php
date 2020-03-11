<?php
namespace Yehunwu\env;

class WebEnv
{

	/**
	 * 解析env
	 * @author Yehunwu
	 * @DateTime 2019-02-13T13:54:25+0800
	 * @throws Yehunwu\env\Exception
	 * @return array
	 */
	static function getEnvKey(array $envs)
	{

		$host = $_SERVER['HTTP_HOST'] ?? '';

		foreach ($envs as $envKey => $rootHostInfo) {

			$rootHostInfo = is_string($rootHostInfo) ? [$rootHostInfo] : $rootHostInfo;

			foreach ($rootHostInfo as $root_host) {

				if (! is_string($root_host)){
					throw new Exception("envs root host error");
				}

				if (self::isRootHost($root_host)){
					return ['env_key' => $envKey, 'root_host' => $root_host];
				}
			}
		}

		throw new Exception("env not found");
	}

	/**
	 * 检测根域名 是否是 域名的根域名
	 * @author Yehunwu
	 * @DateTime 2019-02-13T13:53:39+0800
	 * @param    string                   $checkRootHost [检测的根域名]
	 * @param    string                   $host [域名]
	 * @return   boolean
	 */
	static function isRootHost(string $checkRootHost, string $host = null)
	{
		$host = $host ?? $_SERVER['HTTP_HOST'] ?? '';

		$checkRootHostLength = mb_strlen($checkRootHost);

		switch (mb_strlen($host) <=> $checkRootHostLength) {
			case 1:
				return mb_substr($host, -1 - $checkRootHostLength, null, 'UTF-8') == ('.' . $checkRootHost);
				break;
			case 0:
				return $host == $checkRootHost;
				break;
			case -1:
				return false;
				break;
			default:
				return false;
				break;
		}
	}

}
