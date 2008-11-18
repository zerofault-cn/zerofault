<?php
function GraphPie($arr, $img)
{
	$Values = $arr[Values];
	$Names = $arr[Names];
	
	if(trim($arr[Width])!= '')
	{
		$Width = $arr[Width];
	}else{
		$Width = 350;
	}

	if(trim($arr[Height])!= '')
	{
		$Height = $arr[Height];
	}else{
		$Height = 250;
	}


	$oGraph = new PieGraph($Width,$Height);

    $oGraph->SetShadow();
    $oGraph->title->SetFont(FF_BIG5, FS_NORMAL); 
    $oGraph->legend->SetFont(FF_BIG5, FS_NORMAL);


    $oPiePlot = new PiePlot($Values);

    $oPiePlot->SetLegends($Names);



    $oGraph->Add($oPiePlot);

	$oGraph->Stroke($img);
}


function GraphBar($arr, $img)
{
	$Values		= $arr[Values];
	$Names		= $arr[Names];
	$X_Title	= $arr[Title][X];
    $Y_Title	= $arr[Title][Y];

	if(trim($arr[Width])!= '')
	{
		$Width = $arr[Width];
	}else{
		$Width = 350;
	}

	if(trim($arr[Height])!= '')
	{
		$Height = $arr[Height];
	}else{
		$Height = 250;
	}

	if(trim($arr[FillColor])!= '')
	{
		$FillColor = $arr[FillColor];
	}else{
		$FillColor = 'blue';
	}

	if(trim($arr[YScaleGrace])!= '')
	{
		$YScaleGrace = $arr[YScaleGrace];
	}else{
		$YScaleGrace = 20;
	}

	if(trim($arr[imgMargin])!= '')
	{
		$imgMargin = $arr[imgMargin];
	}else{
		$imgMargin = array(40,30,20,40);
	}

	
	//$aWidth=300,$aHeight=200,$aCachedName="",$aTimeOut=0,$aInline=true
    $oGraph = new Graph($Width,$Height);
            
    $oGraph->SetScale("textlin");
    $oGraph->yaxis->scale->SetGrace($YScaleGrace);
    $oGraph->img->SetMargin($imgMargin[0],$imgMargin[1],$imgMargin[2],$imgMargin[3]);		//lm,$rm,$tm,$bm


    $oBarPlot = new BarPlot($Values);

    // Adjust fill color
    $oBarPlot->SetFillColor($FillColor);
    $oBarPlot->value->Show();
    $oBarPlot->value->SetFont(FF_BIG5, FS_NORMAL);


    $oGraph->Add($oBarPlot);

    // Setup the titles
    $oGraph->xaxis->title->Set($X_Title);
    $oGraph->yaxis->title->Set($Y_Title);

    $oGraph->xaxis->SetFont(FF_BIG5,FS_NORMAL);
    $oGraph->xaxis->SetTickLabels($Names);


    $oGraph->title->SetFont(FF_BIG5, FS_NORMAL);
    $oGraph->yaxis->title->SetFont(FF_BIG5, FS_NORMAL);
    $oGraph->xaxis->title->SetFont(FF_BIG5, FS_NORMAL);


    // Display the graph
    $oGraph->Stroke($img);
}


function GraphLine($arr, $img)
{
	$Values		= $arr[Values];
	$Names		= $arr[Names];

	if(trim($arr[Title][Graph])!= '')
	{
		$Title = $arr[Title][Graph];
	}else{
		$Title = 'Line Title';
	}

	if(trim($arr[Title][X])!= '')
	{
		$X_Title = $arr[Title][X];
	}else{
		$X_Title = 'Line X_Title';
	}

	if(trim($arr[Title][Y])!= '')
	{
		$Y_Title = $arr[Title][Y];
	}else{
		$Y_Title = 'Line Y_Title';
	}

	if(trim($arr[Width])!= '')
	{
		$Width = $arr[Width];
	}else{
		$Width = 350;
	}

	if(trim($arr[Height])!= '')
	{
		$Height = $arr[Height];
	}else{
		$Height = 250;
	}

	if(trim($arr[imgMargin])!= '')
	{
		$imgMargin = $arr[imgMargin];
	}else{
		$imgMargin = array(40,20,20,40);
	}

	if(trim($arr[LineColor])!= '')
	{
		$LineColor = $arr[LineColor];
	}else{
		$LineColor = 'blue';
	}

	if(trim($arr[LineWeight])!= '')
	{
		$LineWeight = $arr[LineWeight];
	}else{
		$LineWeight = 3;
	}


	if(trim($arr[YAxisColor])!= '')
	{
		$YAxisColor = $arr[YAxisColor];
	}else{
		$YAxisColor = 'red';
	}


	if(trim($arr[YAxisWeight])!= '')
	{
		$YAxisWeight = $arr[YAxisWeight];
	}else{
		$YAxisWeight = 2;
	}



	$oGraph = new Graph($Width,$Height);    

	$oGraph->SetScale("textlin");


    // Create the linear plot
    $oLinePlot = new LinePlot($Values);

    $oLinePlot->mark->SetType(MARK_UTRIANGLE);


    // Add the plot to the graph
    $oGraph->Add($oLinePlot);

    $oGraph->img->SetMargin($imgMargin[0],$imgMargin[1],$imgMargin[2],$imgMargin[3]);
    $oGraph->title->Set($Title);
    $oGraph->xaxis->title->Set($X_Title);
    $oGraph->yaxis->title->Set($Y_Title);

    $oGraph->xaxis->SetFont(FF_BIG5,FS_NORMAL);
    $oGraph->xaxis->SetTickLabels($Names);

    $oLinePlot->SetColor($LineColor);
    $oLinePlot->SetWeight($LineWeight);


    $oGraph->yaxis->SetColor($YAxisColor);
    $oGraph->yaxis->SetWeight($YAxisWeight);
    $oGraph->SetShadow();

    // Display the graph
    $oGraph->Stroke($img);
}
?>