<?php 

function setTimeout ($func, $microseconds) 
{ 
    return Timers::setTimeout($func, $microseconds); 
} 

 
function setInterval ($func, $microseconds) 
{ 
    return Timers::setInterval($func, $microseconds); 
} 

 
function clearTimeout ($func, $microseconds) 
{ 
    return Timers::setTimeout($func, $microseconds); 
} 

 
function clearInterval ($interval) 
{ 
    return Timers::clearInterval($interval); 
} 

 
class Timers 
{ 
  private static $timers = array();  
  private static $numTimers = 0; 
  private static $intervals = array(); 
  private static $numIntervals = 0; 

  public static function tick () 
  {  
    $time = self::microtime(); 
        
    foreach (self::$timers as $position => $timer) 
    { 
      if ($time >= $timer['time']) 
      { 
        call_user_func($timer['function']); 
        unset(self::$timers[$position]); 
      } 
    } 
        
    foreach (self::$intervals as $position => $timer) 
    { 
      if ($time >= $timer['time']) 
      { 
        call_user_func($timer['function']); 
        self::$intervals[$position]['time'] = self::microtime() + self::$intervals[$position]['microseconds']; 
      } 
    } 
  } 
  
  public static function microtime () 
  { 
    list($m, $s) = explode(' ', microtime()); 
    return round(((float)$m + (float)$s) * 1000000); 
  } 
     
  public static function shutdown () 
  { 
    foreach (self::$timers as $position => $timer) 
    { 
      call_user_func($timer['function']); 
      unset(self::$timers[$position]); 
    } 
        
    foreach (self::$intervals as $position => $interval) 
    { 
      call_user_func($interval['function']); 
      unset(self::$intervals[$position]); 
    }  
  } 
    
  public static function setTimeout ($func, $microseconds) 
  { 
    if (!is_callable($func)) 
    { 
      if (is_string($func)) 
      { 
        $func = create_function('', $func); 
      } 

      else 
      { 
        throw new InvalidArgumentException(); 
      } 
    } 
        
    self::$timers[++self::$numTimers] = array('time' => self::microtime() + $microseconds, 'function' => $func,); 
        
    return self::$numTimers; 
  } 
    
  public static function setInterval ($func, $microseconds) 
  { 
    if (!is_callable($func)) 
    { 
      if (is_string($func)) 
      { 
        $func = create_function('', $func); 
      } 

      else 
      { 
        throw new InvalidArgumentException(); 
      } 
    } 
        
    self::$intervals[++self::$numIntervals] = array('time' => self::microtime() + $microseconds, 
                                                    'function' => $func, 'microseconds' => $microseconds,); 
        
    return self::$numIntervals; 
  } 
    
  public static function clearTimeout ($timer) 
  { 
    if (isset(self::$timers[$timer])) 
    { 
      unset(self::$timers[$timer]); 
      return true; 
    } 
        
    return false; 
  } 
    

  public static function clearInterval ($interval) 
  { 
    if (isset(self::$intervals[$interval])) 
    { 
      unset(self::$intervals[$interval]); 
      return true; 
    } 
        
    return false; 
  } 

} 
 
register_tick_function(array('Timers','tick')); 
register_shutdown_function(array('Timers','shutdown')); 

?> 