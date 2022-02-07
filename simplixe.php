<?php
function minuse($list1,$list2,$coef){
    $newlist = [] ;
    for($i=0;$i<count($list1);$i++){
        $newlist[] = $list1[$i] - $coef*$list2[$i];
    }
    return $newlist;
}
class Simplixe {
    function __construct($matrix, $coef, $contrant, $les_b,$is_max=TRUE)
    {
        $this->nombre_x = count($coef);
        $this->matrix = $matrix;
        $this->is_max = $is_max;
        $this->coef = $coef;
        $this->Ci_Zi = array();
        $this->Zi = array();
        $this->Z = 0;
        $count = 0;
        foreach($contrant as $const){
            if(abs($const)==1){
                for($i = 0;$i<count($matrix);$i++){
                    if($i==$count){
                        $this->matrix[$i][] = -1*$const;
                    }else{
                        $this->matrix[$i][] = 0;
                    }
                }
                if($const==1 && $les_b[$count]>0){
                    for($i = 0;$i<count($matrix);$i++){
                        if($i==$count){
                            $this->matrix[$i][] = 1*$const;
                        }else{
                            $this->matrix[$i][] = 0;
                        }
                    }
                }
                if($const==-1 && $les_b[$count]<0){
                    for($i = 0;$i<count($matrix);$i++){
                        if($i==$count){
                            $this->matrix[$i][] = 1*$const;
                        }else{
                            $this->matrix[$i][] = 0;
                        }
                    }
                }
                $this->coef[] = 0;
                $this->Zi[] = 0;
            }
            $count++;
        }
        $count = 0;
        for($i=0;$i<count($matrix);$i++){
            $this->matrix[$i][] = $les_b[$i];
        }
        $this->row = count($this->matrix);
        $this->col = count($this->matrix[0]);
        for($i=0;$i<$this->col-1;$i++)
            $this->Ci_Zi[] = 0;
    }
    public function calcule_C_Z(){
        for($i=0;$i<$this->col-1;$i++){
            $this->Ci_Zi[$i] = $this->coef[$i] - $this->produit_Zi_ai($i);
        }
        $this->Z = $this->produit_Zi_ai($this->col-1);
    }
    public function produit_Zi_ai($n){
        $sum = 0;
        for($i=0;$i<$this->row;$i++){
            $sum += $this->matrix[$i][$n]*$this->Zi[$i];
        }
        return $sum;
    }
    public function tout_positif(){
        foreach($this->Ci_Zi as $case){
            if($case<0)
                return FALSE;
        }
        return TRUE;
    }
    public function tout_negatif(){
        foreach($this->Ci_Zi as $case){
            if($case>0)
                return FALSE;
        }
        return TRUE;
    }
    public function tout_nulle(){
        foreach($this->Ci_Zi as $case){
            if($case!=0)
                return FALSE;
        }
        return TRUE;
    }
    public function one_step(){
        $this->calcule_C_Z();
        if(($this->is_max && !$this->tout_negatif() && !$this->tout_nulle()) || (!$this->is_max && !$this->tout_positif() && !$this->tout_nulle())){
            $this->pivot_autour($this->le_pivot());
            return TRUE;
        }else{
            return FALSE;
        }
    }
    public function le_pivot(){
        if($this->is_max){
            $max = $this->Ci_Zi[0];
            $index = 0;
            for($i=0;$i<$this->col-1;$i++){
                if($this->Ci_Zi[$i]>=$max){
                    $max = $this->Ci_Zi[$i];
                    $index = $i;
                }
            }
        }else{
            $min = $this->Ci_Zi[0];
            $index = 0;
            for($i=0;$i<$this->col-1;$i++){
                if($this->Ci_Zi[$i]<=$min){
                    $min = $this->Ci_Zi[$i];
                    $index = $i;
                }
            }
        }
        $min_b_divise_a = 0;
        $jndex = 0;
        for($i=0;$i<$this->row;$i++){
            if($min_b_divise_a ==0 &&  $this->matrix[$i][$this->col-1]/$this->matrix[$i][$index]>0){
                $min_b_divise_a = $this->matrix[$i][$this->col-1]/$this->matrix[$i][$index];
                $jndex = $i;
            }
            if($min_b_divise_a>$this->matrix[$i][$this->col-1]/$this->matrix[$i][$index]){
                $min_b_divise_a = $this->matrix[$i][$this->col-1]/$this->matrix[$i][$index];
                $jndex = $i;
            }
        }
        $this->Zi[$jndex] = $this->coef[$index];
        return [$index,$jndex];
    }
    public function pivot_autour($le_pivot){
        $a = $this->matrix[$le_pivot[1]][$le_pivot[0]] ;
        for($i=0;$i<$this->col;$i++){
            $this->matrix[$le_pivot[1]][$i] /= $a;
        }
        for($i=0;$i<$this->row;$i++){
            if($i!=$le_pivot[1]){
                $this->matrix[$i] = minuse($this->matrix[$i],$this->matrix[$le_pivot[1]],$this->matrix[$i][$le_pivot[0]]);
            }
        }
    }
    public function les_x(){
        $les_x = [];
        for($i=0;$i<$this->row;$i++){
            $les_x[] = "0";
        }
        for($i=0;$i<$this->row;$i++){
            if($this->Zi[$i]!=0){
                $les_x[array_search($this->Zi[$i],$this->coef)] = "{$this->matrix[$i][$this->col-1]}";
            }
        }
        return implode("-",array_slice($les_x, 0, $this->nombre_x));
    }
}
$matrix = [[5,2],[1,1],[1,2]];
$les_b = [80,20,30];
$coef = [10,15];
$contrant = [1,-1,-1];
$simplixe = new Simplixe($matrix,$coef,$contrant,$les_b);
echo '<pre>';
print_r(var_dump($simplixe->matrix));
echo '</pre>';
?>

