<?php

namespace Disco\addon\Foundation;

class Foundation {


    /**
     *      Create a Magellan Stick Nav From:
     *          - http://foundation.zurb.com/docs/components/magellan.html
     *
     *      @param string $markup the html to process the magellan from
     *      @param string $pattern the pattern to use to find the nav links to create
     *      @param string $classes the classes to apply to the magellan sticky nav
     *      @param string $type the type of sticky nav
     *      @return array
    */
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



    /**
     *      Extract the text of a elements matching a pattern and return them as an array
     *
     *      @param string $markup the html to look through
     *      @param string $pattern the pattern to use to search the html
     *      @return array $return
     *
    */
    public function extract($markup,$pattern){

        $doc = \phpQuery::newDocument($markup);

        $return = Array();
        foreach($doc[$pattern] as $ele){
            $return[] = \pq($ele)->text();
        }//foreach

        return $return;

    }//extract



    /**
     *      Create a Top Bar from:
     *      - foundation.zurb.com/docs/components/topbar.html
     *
     *      @param array $d 
     *      @return string 
     *
    */
    public function topbar($d){

        $tmp = Array('classes'=>'','name'=>'','left'=>'','right'=>'');
        foreach($d as $k=>$v){
            $tmp[$k]=$v;
        }//foreach
        $d=$tmp;

        $t = "
<nav class='top-bar %3\$s' data-topbar> 
    <ul class='title-area'> 
        <li class='name'><a href='#'>{$d['name']}</a></li> 
        <li class='toggle-topbar menu-icon'><a href='#'><span>Menu</span></a></li> 
    </ul> 
    <section class='top-bar-section'> 
            %1\$s
            %2\$s
    </section> 
</nav>
        ";

        $l = "<ul class='left'>%1\$s</ul>";
        $r = "<ul class='right'>%1\$s</ul>";

        if($d['left']!='')
            $l = sprintf($l,$d['left']);
        if($d['right']!='')
            $l = sprintf($r,$d['right']);


        return sprintf($t,$r,$l,$d['classes']);

    }//topbar

}//Foundation

?>
