<?php
/**
 * ルーター
 *
 */
class Base_Router
{
	protected $routes;





	public function compileRoutes($router)
	{
		$routes = array();


		foreach($router as $url => $params)
		{

			$tokens = explode('/',rtrim(ltrim($url,'/'),'/'));
			foreach($tokens as $i => $token)
			{
				if(0 === strpos($token,':'))
				{
					$name = substr($token,1);
					$type = 'any';

					if(strpos($name,':') !== false)
					{
						$temp = explode(":",$name);
						$name = $temp[0];
						$type = $temp[1];
					}

					if($type=="numeric")
					{
						$token = '(?P<'.$name.'>[0-9]+)';
					}
					else
					{
						$token = '(?P<'.$name.'>[^/]+)';
					}
				}
				$tokens[$i] = $token;
			}

			$pattern = '/'.implode('/',$tokens);
			$routes[$pattern] = $params;
		}


		$this->routes = $routes;
	}


	public function resolve($path_info)
	{
		if('/' !== substr($path_info,0,1))
		{
			$path_info = '/'.rtrim($path_info,'/');
		}


		foreach($this->routes as $pattern => $params)
		{
			if(preg_match('#^'.$pattern.'$#',$path_info,$matches))
			{
				foreach($matches as $key=>$val)
				{
					if(is_numeric($key))
					{
						unset($matches[$key]);
					}
				}
				if(!$matches)
				{
					return $params;
				}
				$params = array_merge($params,$matches);
				return $params;
			}
		}

		return false;
	}
}