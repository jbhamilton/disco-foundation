<?php

namespace Disco\addon\Foundation;

class Foundation {

    public function magellan($markup,$pattern,$classes='',$type=''){

        $t = "
            <div class='magellan-container {$classes}' data-magellan-expedition='{$type}'> 
                <dl class='sub-nav'> 
                    %1\$s
                </dl> 
            </div>
            ";
        $dd = "<dd data-magellan-arrival='%2\$s'><a href='#%2\$s'>%1\$s</a></dd>";

        $headings = self::extract($markup,$pattern);
        $ids = $headings;
        foreach($ids as $k=>$id){
            $ids[$k] = str_replace(' ','-',$id);
        }//foreach

        if(count($headings)!=count($ids)){
            return false;
        }//if

        $doc = \phpQuery::newDocument($markup);

        foreach($doc[$pattern] as $k=>$ele){
            \pq($ele)->attr('data-magellan-destination',$ids[$k])->attr('id',$ids[$k]);
        }//foreach

        $markup = $doc->html();

        $html='';
        foreach($headings as $k=>$v){
            $html.=sprintf($dd,$v,$ids[$k]);
        }//for

        $magellan = sprintf($t,$html);

        return Array('magellan'=>$magellan,'markup'=>$markup);

    }//magellan


    public function extract($markup,$pattern){

        $doc = \phpQuery::newDocument($markup);

        $return = Array();
        foreach($doc[$pattern] as $ele){
            $return[] = \pq($ele)->text();
        }//foreach

        return $return;

    }//extract

    public function addClass($markup,$pattern,$class){

        
    }//addClass

}//Foundation

?>
