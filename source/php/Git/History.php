<?php

/**
* This file is part of the Altumo library.
* 
* (c) Steve Sperandeo <steve.sperandeo@altumo.com>
* (c) Juan Jaramillo <juan.jaramillo@altumo.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/




namespace Altumo\Git;


/**
* This class is used to retrieve the git revision history.
* 
* @author Steve Sperandeo <steve.sperandeo@altumo.com>
* @author Juan Jaramillo <juan.jaramillo@altumo.com>
*/
class History{


    /**
    * Gets the last commit as an array.
    * The SHA1 is the array key and the value is a string with the comments of
    * the commit (on one line).
    * 
    *    returned array looks like this:
    *      array(1) {
    *         ["7b8e0cee0a58f05ef9e48e6daabfa07c3ebe728d"]=>
    *         string(34) "Fixed bug in Not interested button"
    *      }
    * 
    * @return array
    */
    static public function getLastCommit(){
        
        //get the revision log
            $git_log_output = `git log --no-color --pretty=oneline -n 1`;
            $revisions = self::parseOneLineFormat( $git_log_output );
            return $revisions;
        
    }
    
    
    /**
    * Gets the last commit as a string hash.
    * 
    * @return string
    */
    static public function getLastCommitHash(){
        
        //get the revision log        
            $last_commit = self::getLastCommit();
            $commit_hashes = array_keys( $last_commit );
            return reset( $commit_hashes );
        
    }    

    
    /**
    * Retrieves any commits posted (cronologically) after $from_hash and before 
    * $until_hash that contain a log message matching the $regex_pattern given.
    * 
    * 
    * @param mixed $regex_pattern
    *   // a grep-style regular expression to match log messages against.
    *   // IMPORTANT: Do not use php-style regex (e.g. no slashes needed)
    * 
    * @param mixed $from_hash
    *   // the commit hash to start from. The set used will be $from_hash until $until_hash    
    *  
    * @param mixed $until_hash
    *   // defaults to HEAD
    * 
    * @return array
    */
    static public function getCommitsAfterMatching( $regex_pattern, $from_hash, $until_hash = 'HEAD' ){
        
        $command = "git log --pretty=oneline --no-color --date-order --grep=\"{$regex_pattern}\" {$from_hash}..{$until_hash}";
        $git_log_output = `$command`;
        $revisions = self::parseOneLineFormat( $git_log_output );
        return $revisions;
            
    }
    
    
    /**
    * Parses the output from git log into an array.
    *  eg. git log --pretty=oneline
    * 
    *    returned array looks like this:
    *      array(2) {
    *         ["7b8e0cee0a58f05ef9e48e6daabfa07c3ebe728d"]=>
    *         string(34) "Fixed bug in Not interested button"
    *         ["d5180559dbc1d39fb802a17b832b9e52f3f2a964"]=>
    *         string(17) "Updated task list"
    *      }
    *
    * @param string $git_log_result
    * @return array
    */
    static protected function parseOneLineFormat( $git_log_result ){
        
        $revisions = array();
        preg_match_all( '/^(.*?)\\s(.*?)$/m', $git_log_result, $results, PREG_SET_ORDER );    
        foreach( $results as $result ){
            $revisions[ $result[1] ] = $result[2];
        }
        return $revisions;
        
    }
    
}