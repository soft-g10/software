<?php
$user = 'admin';
$pw = 'softwaregroup10';
$dnsinfo = "mysql:dbname=group10; host=database-2.crjrdcbc45me.us-east-1.rds.amazonaws.com; port=3306; charset=utf8";
$pdo = new PDO($dnsinfo, $user, $pw);

$property_sql = "SELECT * FROM property_info";

$property_sql = "SELECT * FROM property_info ORDER BY rent desc";

$count_sql = "SELECT COUNT(*) FROM property_info";
$count_stmt = $pdo->prepare($count_sql);
$count_stmt->execute(null);
$count_total = $count_stmt->fetchColumn(PDO::FETCH_ASSOC);
$pages = ceil($count_total / 10);
?>

<!DOCTYPE html> <!-- html文章の記述であると宣言する -->
<html>
<!-- htmlのコードの開始を明示する -->

<head>
	<!-- ヘッダー（タブに表示されるタイトルの設定など） -->
	<title>KUT不動産-PreviewRoom-</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="Home.css">
</head>


<body>
	<!-- 実際に画面に表示される部分である -->
	<nav class="stick center">
		<a href="TopPage.htm"><button class="buttonA">KUT不動産</button></a>
		<a href="#"><button>物件一覧</button></a>
		<a href="#"><button>お気に入りリスト</button></a>
		<a href="#"><button>マイアカウント</button></a>
		<a href="#"><button>ログアウト</button></a>
	</nav>

	<p class="ichiran">物件一覧（○○件）</p>
	<select class="narabekae" onChange="Sort()">
		<option>----------------</option>
		<option value="1">家賃が安い順</option>
		<option value="2">家賃が高い順</option>
		<option value="3">築年数が新しい順</option>
	</select>
	<div class="bukken">
		<?php
		$property_sql = $_POST['sql'];
		$property_stmt = $pdo->prepare($property_sql);
		$property_stmt->execute(null);
		for ($i = 0; $i < 10; $i++) {
			$property_list = $property_stmt->fetch(PDO::FETCH_ASSOC);
			$picture_sql = "SELECT * FROM picture WHERE property_id = '{$property_list['property_id']}'";
			$picture_stmt = $pdo->prepare($picture_sql);
			$picture_stmt->execute(null);
			$picture_list = $picture_stmt->fetch(PDO::FETCH_ASSOC);
		?>

			<h2>賃貸アパート</h2>
			<a href="物件詳細画面へのリンク">
				<p class="bukkennmei">
					<?php echo $property_list['property_name'] ?>
				</p>
			</a>

			<?php
			$picture = '<img src=';
			$picture .= '"' . $picture_list['picture1'] . '" ';
			$picture .= 'alt=';
			$picture .= '"' . $property_list['property_name'] . '" ';
			$picture .= 'title=';
			$picture .= '"' . $property_list['property_name'] . '" ';
			$picture .= 'width="400" height="400">';
			echo $picture;
			?>

			<table class="bukkenjo">
				<thead>
					<tr class="yachin_hyou">
						<th>家賃</th>
						<th>
							<?php
							$rent = $property_list['rent'];
							echo $rent;
							?>
							万円</th>
					</tr>
				</thead>
				<tbody class="bukknen_instance">
					<tr>
						<td>住所</td>
						<td>
							<?php $address = $property_list['address'];
							echo $address;
							?>
						</td>
					</tr>
					<tr>
						<td>築年数</td>
						<td>
							<?php $building_age = $property_list['building_age'];
							echo $building_age;
							?>
						</td>
					</tr>
					<tr>
						<td>間取り</td>
						<td>
							<?php
							$floor_plan_info = $property_list['floor_plan_info'];
							echo $floor_plan_info;
							?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php } ?>
	</div>

	<div class="siborikomi">
		<p>絞り込み条件
			<p>
				<div class="yachin">
					<p>家賃　　　　　～</p>
					<input type="text" class="yachin_min">
					<input type="text" class="yachin_max">

				</div>
				<div class="tatemono">
					<p>建物の種類</p>
					<select class="tatemono_syurui">
						<option>----------</option>
						<option>マンション</option>
						<option>アパート</option>
						<option>一軒家</option>
					</select>
				</div>
				<div class="madori">
					<p>間取り</p>
					<select class="madori_syurui">
						<option>----------</option>
						<option>ワンルーム</option>
						<option>1K</option>
						<option>1DK</option>
						<option>1LDK</option>
						<option>2K</option>
						<option>2DK</option>
						<option>2LDK</option>
						<option>3K</option>
						<option>3DK</option>
						<option>3LDK</option>
						<option>4k</option>
						<option>4DK</option>
						<option>4LDK以上</option>
					</select>
				</div>
				<div class="keyword">
					<form>
						<b>キーワード</b><br>
						<input type="checkbox" name="parking" value="1">駐車場あり <br>
						<input type="checkbox" name="bath_toilet" value="2">バス・トイレ別 <br>
						<input type="checkbox" name="pet" value="3">ペット可<br>
						<input type="checkbox" name="corner" value="4">角部屋<br>
						<input type="checkbox" name="internet" value="4">インターネット環境<br>
						<input type="checkbox" name="soundproof" value="4">防音響<br>
						<input type="checkbox" name="security" value="4">セキュリティ<br>
						<button type="button" class="search_button">検索</button>
					</form>
				</div>
	</div>

	<!-- js記述 -->
	<script language="javascript" type="text/javascript">
		function Sort() {
			var SortType = document.getElementById("sort");
			if (SortType.value === "1") {

				var postdata = {
					"sql": "SELECT * FROM property_info ORDER BY rent asc"
				}
				$.post({
					"Home.php?",
					postdata
				});

			} else if (SortType.value === "2") {


			}

		}
	</script>

</body>

</html>