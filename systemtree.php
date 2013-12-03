<?php
include_once 'includes/MiscFunctions.php';
include_once 'includes/header.php';
error_reporting(0);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Spacetree - SpaceTree with on-demand nodes</title>

<!-- CSS Files -->
<link type="text/css" href="css/base.css" rel="stylesheet" />
<link type="text/css" href="css/Spacetree.css" rel="stylesheet" />

<!--[if IE]><script language="javascript" type="text/javascript" src="../../Extras/excanvas.js"></script><![endif]-->

<!-- JIT Library File -->
<script language="javascript" type="text/javascript" src="javascripts/jit-yc.js"></script>

</head>


<body onload="init();">
<div id="container">
    <div id="center-container" style="margin-top: 0px; margin-bottom: 0px;">
    <div id="infovis">
        <?php
            /*$child_array = "{id:'1', name: 'আব্দুর_রহিম', data:{},
                                                children:[
                                                            {id:'40', name: 'জেসি_হক', data:{}},
                                                            {id:'3', name: 'সালেহ', data:{},
                                                                        children:[
                                                                                    {id:'41', name: 'লিসা', data:{}},
                                                                                    {id:'8', name: 'রহিম_তালুকদার', data:{},
                                                                                                children:[
                                                                                                            {id:'38', name: 'আবুল', data:{}},
                                                                                                            {id:'35', name: 'করিম', data:{}},
                                                                                                            ]},
                                                                                    ]},
                                                            {id:'2', name: 'মীর_জাফর', data:{},
                                                                        children:[
                                                                                    {id:'39', name: 'নতুন_ভাই', data:{}},
                                                                                    {id:'7', name: 'আব্দুন_নূর_তুষার', data:{},
                                                                                                children:[
                                                                                                            {id:'34', name: 'কামাল', data:{}},
                                                                                                            {id:'33', name: 'জামাল', data:{}},
                                                                                                            ]},
                                                                                    {id:'4', name: 'নাইম', data:{},
                                                                                                children:[
                                                                                                            { id:'11', name: 'বশির', data:{} },
                                                                                                            ]},
                                                                                    ]},
                                                        ]}";*/
            
            $array_tree = array();
                    
            recurrance_tree(3, 1);
            array_push($array_tree, array(0, "id:'1', name: 'আব্দুর_রহিম', data:{}")); //it should be made from query by session user id
            $reversed_array = array_reverse($array_tree);
            array_push($reversed_array, array(0, "blank"));
            //print_r($reversed_array);
            
            $size_arr = sizeof($reversed_array)-1;
            $send_json_string;
            for($a = 0; $a < $size_arr; $a = $a + 1)
                    {
                    if($reversed_array[$a][0] == $reversed_array[$a+1][0])
                            {
                            $new_string = "{".$reversed_array[$a][1]. "},";
                            }
                    elseif($reversed_array[$a][0] < $reversed_array[$a+1][0])
                            {
                            $new_string = "{".$reversed_array[$a][1]. ", children: [";
                            }
                    elseif($reversed_array[$a][0] > $reversed_array[$a+1][0])
                            {
                            $end_tag = null;
                            $difference = $reversed_array[$a][0] - $reversed_array[$a + 1][0];
                            $new_string = "{".$reversed_array[$a][1]. "},";
                            for($b = 0; $b < $difference; $b = $b+1) $end_tag .= "]},";
                            if($reversed_array[$a + 1][0] == 0) $end_tag = substr ($end_tag, 0, -1);
                            $new_string = $new_string.$end_tag;
                            }
                    $send_json_string .= $new_string;
                    }
            //echo $send_json_string;
            
            function recurrance_tree($parent_ID, $level)
                    {
                    global $array_tree;
                    $tree_sql = mysql_query("select  * from $dbname.customer_account where referer_id = $parent_ID");
                    while($row_sql=  mysql_fetch_array($tree_sql))
                            {
                            $self_id = $row_sql['idCustomer_account'];
                            $self_name = $row_sql['cust_father_name'];
                            $changed_name = str_replace(" ", "_", $self_name);
                            if($level < 5) recurrance_tree($self_id, $level+1);
                            $json_str = "id: '".$self_id."', name: '".$changed_name."', data:{}";
                            array_push($array_tree, array($level, $json_str));
                            }
                    }
     
    ?>
    </div>    
    
</div>
<div id="left-container">

</div>

<div id="right-container">

<h4>Change Tree Orientation</h4>
<table>
    <tr>
         <td>
            <label for="r-top">top</label>
         </td>
         <td>
            <input type="radio" id="r-top" name="orientation" checked="" value="top" />
         </td>
    </tr>
    <tr>
        <td>
            <label for="r-left">left </label>
        </td>
        <td>
            <input type="radio" id="r-left" name="orientation" value="left" />
        </td>
    </tr>
    <tr>
         <td>
            <label for="r-bottom">bottom </label>
          </td>
          <td>
            <input type="radio" id="r-bottom" name="orientation" value="bottom" />
          </td>
    </tr>
    <tr>
          <td>
            <label for="r-right">right </label>
          </td> 
          <td> 
           <input type="radio" id="r-right" name="orientation" value="right" />
          </td>
    </tr>
</table>


</div>

<div id="log"></div>
</div>
</body>
    
<!-- Example File -->
<script language="javascript" type="text/javascript">
var labelType, useGradients, nativeTextSupport, animate;

(function() {
  var ua = navigator.userAgent,
      iStuff = ua.match(/iPhone/i) || ua.match(/iPad/i),
      typeOfCanvas = typeof HTMLCanvasElement,
      nativeCanvasSupport = (typeOfCanvas == 'object' || typeOfCanvas == 'function'),
      textSupport = nativeCanvasSupport 
        && (typeof document.createElement('canvas').getContext('2d').fillText == 'function');
  //I'm setting this based on the fact that ExCanvas provides text support for IE
  //and that as of today iPhone/iPad current text support is lame
  labelType = (!nativeCanvasSupport || (textSupport && !iStuff))? 'Native' : 'HTML';
  nativeTextSupport = labelType == 'Native';
  useGradients = nativeCanvasSupport;
  animate = !(iStuff || !nativeCanvasSupport);
})();

var Log = {
  elem: false,
  write: function(text){
    if (!this.elem) 
      this.elem = document.getElementById('log');
    this.elem.innerHTML = text;
    this.elem.style.left = (500 - this.elem.offsetWidth / 2) + 'px';
  }
};


function init(){
    //init data    
    var obj= <?php echo json_encode($send_json_string);?>;
    var json = obj; 
    //end
    
    //A client-side tree generator
    var getTree = (function() {
        var i = 0;
        return function(nodeId, level) {
          var subtree = eval('(' + json.replace(/id:\"([a-zA-Z0-9]+)\"/g, 
          function(all, match) {
            return "id:\"" + match + "_" + i + "\""  
          }) + ')');
          $jit.json.prune(subtree, level); i++;
        };
    })();
    
    //Implement a node rendering function called 'nodeline' that plots a straight line
    //when contracting or expanding a subtree.
    $jit.ST.Plot.NodeTypes.implement({
        'nodeline': {
          'render': function(node, canvas, animating) {
                if(animating === 'expand' || animating === 'contract') {
                  var pos = node.pos.getc(true), nconfig = this.node, data = node.data;
                  var width  = nconfig.width, height = nconfig.height;
                  var algnPos = this.getAlignedPos(pos, width, height);
                  var ctx = canvas.getCtx(), ort = this.config.orientation;
                  ctx.beginPath();
                  if(ort == 'left' || ort == 'right') {
                      ctx.moveTo(algnPos.x, algnPos.y + height / 2);
                      ctx.lineTo(algnPos.x + width, algnPos.y + height / 2);
                  } else {
                      ctx.moveTo(algnPos.x + width / 2, algnPos.y);
                      ctx.lineTo(algnPos.x + width / 2, algnPos.y + height);
                  }
                  ctx.stroke();
              } 
          }
        }
          
    });

    //init Spacetree
    //Create a new ST instance
    var st = new $jit.ST({
        'injectInto': 'infovis',
        //set duration for the animation
        duration: 800,
        //set animation transition type
        transition: $jit.Trans.Quart.easeInOut,
        //set distance between node and its children
        levelDistance: 50,
        //set max levels to show. Useful when used with
        //the request method for requesting trees of specific depth
        levelsToShow: 2,
        //set node and edge styles
        //set overridable=true for styling individual
        //nodes or edges
        Node: {
            height: 20,
            width: 90,
            //use a custom
            //node rendering function
            type: 'nodeline',
            color:'#23A4FF',
            lineWidth: 2,
            align:"center",
            overridable: true
        },
        
        Edge: {
            type: 'bezier',
            lineWidth: 2,
            color:'#23A4FF',
            overridable: true
        },
        
        //Add a request method for requesting on-demand json trees. 
        //This method gets called when a node
        //is clicked and its subtree has a smaller depth
        //than the one specified by the levelsToShow parameter.
        //In that case a subtree is requested and is added to the dataset.
        //This method is asynchronous, so you can make an Ajax request for that
        //subtree and then handle it to the onComplete callback.
        //Here we just use a client-side tree generator (the getTree function).
        request: function(nodeId, level, onComplete) {
          var ans = getTree(nodeId, level);
          onComplete.onComplete(nodeId, ans);  
        },
        
        onBeforeCompute: function(node){
            Log.write("জেনোলোজি ট্রি লোড হচ্ছেঃ " + node.name);
        },
        
        onAfterCompute: function(){
            Log.write("ট্রি সম্পন্ন হয়েছে");
        },
        
        //This method is called on DOM label creation.
        //Use this method to add event handlers and styles to
        //your node.
        onCreateLabel: function(label, node){
            label.id = node.id;            
            label.innerHTML = node.name;
            label.onclick = function(){
                st.onClick(node.id);
            };
            //set label styles
            var style = label.style;
            style.width = 40 + 'px';
            style.height = 17 + 'px';            
            style.cursor = 'pointer';
            style.color = '#fff';
            //style.backgroundColor = '#1a1a1a';
            style.fontSize = '0.8em';
            style.textAlign= 'center';
            style.textDecoration = 'underline';
            style.paddingTop = '3px';
        },
        
        //This method is called right before plotting
        //a node. It's useful for changing an individual node
        //style properties before plotting it.
        //The data properties prefixed with a dollar
        //sign will override the global node style properties.
        onBeforePlotNode: function(node){
            //add some color to the nodes in the path between the
            //root node and the selected node.
            if (node.selected) {
                node.data.$color = "#ff7";
            }
            else {
                delete node.data.$color;
            }
        },
        
        //This method is called right before plotting
        //an edge. It's useful for changing an individual edge
        //style properties before plotting it.
        //Edge data proprties prefixed with a dollar sign will
        //override the Edge global style properties.
        onBeforePlotLine: function(adj){
            if (adj.nodeFrom.selected && adj.nodeTo.selected) {
                adj.data.$color = "#eed";
                adj.data.$lineWidth = 3;
            }
            else {
                delete adj.data.$color;
                delete adj.data.$lineWidth;
            }
        }
    });
    //load json data
    st.loadJSON(eval( '(' + json + ')' ));
    //compute node positions and layout
    st.compute();
    //emulate a click on the root node.
    st.onClick(st.root);
    //end
    //Add event handlers to switch spacetree orientation.
   function get(id) {
      return document.getElementById(id);  
    };

    var top = get('r-top'), 
    left = get('r-left'), 
    bottom = get('r-bottom'), 
    right = get('r-right');
    
    function changeHandler() {
        if(this.checked) {
            top.disabled = bottom.disabled = right.disabled = left.disabled = true;
            st.switchPosition(this.value, "animate", {
                onComplete: function(){
                    top.disabled = bottom.disabled = right.disabled = left.disabled = false;
                }
            });
        }
    };
    
    top.onchange = left.onchange = bottom.onchange = right.onchange = changeHandler;
    //end

}
</script>
<?php 
    include_once 'includes/footer.php';
?>
