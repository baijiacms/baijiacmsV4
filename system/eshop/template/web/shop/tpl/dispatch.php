<?php defined('IN_IA') or exit('Access Denied');?><tr class='<?php  echo $random;?>'>

    <td style="word-break:break-all;overflow:hidden;width:auto;padding:10px;line-height:22px;">
        <span class='cityshtml'><?php  echo $row['citys'];?></span>
        <input type="hidden" name="random[]" value="<?php  echo $random;?>" />
        <input type="hidden" class='citys' name="citys[<?php  echo $random;?>]" value="<?php  echo $row['citys'];?>" />
        <a href='javascript:;' onclick='editArea(this)' random="<?php  echo $random;?>">编辑</a>
    </td>
    <td class="show_h text-center"><input type="number" value="<?php echo empty($row['firstweight'])?1000:$row['firstweight']?>" class="form-control" name="firstweight[<?php  echo $random;?>]" style="width:100px;"></td>
    <td class="show_h text-center"><input type="text" value="<?php  echo $row['firstprice'];?>" class="form-control" name="firstprice[<?php  echo $random;?>]" style="width:100px;"></td>
    <td class="show_h text-center"><input type="number" value="<?php echo empty($row['secondweight'])?1000:$row['secondweight']?>" class="form-control" name="secondweight[<?php  echo $random;?>]" style="width:100px;"></td>
    <td class="show_h text-center"><input type="text" value="<?php  echo $row['secondprice'];?>" class="form-control" name="secondprice[<?php  echo $random;?>]" style="width:100px;"></td>

    <td class="show_n text-center"><input type="number" value="<?php echo empty($row['firstnum'])?1:$row['firstnum']?>" class="form-control" name="firstnum[<?php  echo $random;?>]" style="width:100px;"></td>
    <td class="show_n text-center"><input type="text" value="<?php  echo $row['firstnumprice'];?>" class="form-control" name="firstnumprice[<?php  echo $random;?>]" style="width:100px;"></td>
    <td class="show_n text-center"><input type="number" value="<?php echo empty($row['secondnum'])?1:$row['secondnum']?>" class="form-control" name="secondnum[<?php  echo $random;?>]" style="width:100px;"></td>
    <td class="show_n text-center"><input type="text" value="<?php  echo $row['secondnumprice'];?>" class="form-control" name="secondnumprice[<?php  echo $random;?>]" style="width:100px;"></td>

    <td><a href='javascript:;' onclick='$(this).parent().parent().remove()'><i class='fa fa-remove'></i></td>
</tr> 