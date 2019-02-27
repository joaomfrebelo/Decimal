using System;
using System.Globalization;
using System.Reflection;

namespace Rebelo.Test.Decimal.GenerateDecimalSamples
{
	class GenerateSample
	{

		public static void GenerateSum()
		{
			try
			{
				string path = System.IO.Path.GetDirectoryName(Assembly.GetEntryAssembly().Location);
				string pathSum = path + @"\decimalsSum.php";

				System.IO.FileStream streamSum = System.IO.File.Create(pathSum);
				streamSum.Close();
				streamSum.Dispose();

				decimal maxPre = 12m;//12m;
				decimal init = 0m;
				decimal end = 10m;//100
				decimal step = 0.01m;//0.01

				System.IO.StreamWriter writterSum = System.IO.File.AppendText(pathSum);
				writterSum.WriteLine("<?php");
				writterSum.WriteLine("$return = array(");

				for (decimal precision = maxPre; precision > 0; precision--)
				{
					for (decimal decimals = maxPre; decimals >= 0; decimals--)
					{
						decimal lInt = init;
						do
						{
							string sum;
							if (decimals == 0)

							{
								sum = "0";
							}
							else if (decimals == 1)
							{
								sum = "0.1";
							}
							else
							{
								sum = "0.";
								sum = sum.PadRight((int)(decimals + 1), '0') + "1";
							}
							NumberFormatInfo numinf = new NumberFormatInfo();
							numinf.NumberDecimalSeparator = ".";

							decimal left = decimal.Round(lInt, (int)precision, MidpointRounding.AwayFromZero);
							decimal right = decimal.Parse(sum, numinf);
							decimal resultSum = decimal.Round(decimal.Add(left, right), (int)precision, MidpointRounding.AwayFromZero);
							
							string msgSum =
								String.Format("{0:0.##############}", left)
								+ ";" + String.Format("{0:0.##############}", right)
								+ ";" + String.Format("{0:0.##############}", resultSum)
								+ ";" + String.Format("{0:0.##############}", precision)
								+ ";" + String.Format("{0:0.##############}", decimals);
														
							//System.Console.WriteLine("array("+msg.Replace(",",".").Replace(";",",") + "),");
							writterSum.WriteLine("array(" + msgSum.Replace(",", ".").Replace(";", ",") + "),");
							
							lInt += step;
							writterSum.Flush();
						}
						while (lInt <= end);
					}
				}
				writterSum.WriteLine(");");
				writterSum.WriteLine("");
				writterSum.Flush();
				writterSum.Close();
				writterSum.Dispose();				
			}
			catch (Exception e)
			{
				System.Console.WriteLine(e.Message);
			}
		}

		public static void GenerateMul()
		{

			try
			{
				string path = System.IO.Path.GetDirectoryName(Assembly.GetEntryAssembly().Location);
				string pathMul = path + @"\decimalsMul.php";
				
				System.IO.FileStream streamMul = System.IO.File.Create(pathMul);
				streamMul.Close();
				streamMul.Dispose();
								
				System.IO.StreamWriter writterMul = System.IO.File.AppendText(pathMul);
				writterMul.WriteLine("<?php");
				writterMul.WriteLine("$return = array(");

				for(decimal left = 1; left <= 10; left++)
				{
					for(decimal right = 0.1m; right < 1; right += 0.1m)
					{
						decimal resultMul = decimal.Round(left * right, 2, MidpointRounding.AwayFromZero);
						string msgMul =
								String.Format("{0:0.##############}", left)
								+ ";" + String.Format("{0:0.##############}", right)
								+ ";" + String.Format("{0:0.##############}", resultMul)
								+ ";" + String.Format("{0:0.##############}", 2)
								+ ";" + String.Format("{0:0.##############}", 2);

						//System.Console.WriteLine("array("+msg.Replace(",",".").Replace(";",",") + "),");
						writterMul.WriteLine("array(" + msgMul.Replace(",", ".").Replace(";", ",") + "),");
						writterMul.Flush();

					}
				}

				writterMul.WriteLine(");");
				writterMul.WriteLine("");
				writterMul.Flush();
				writterMul.Close();
				writterMul.Dispose();
			}
			catch (Exception e)
			{
				System.Console.WriteLine(e.Message);
			}
		}



		public static void Generate()
		{
			try
			{
				string path = System.IO.Path.GetDirectoryName(Assembly.GetEntryAssembly().Location);
				string pathSub = path + @"\decimalsSub.php";
				string pathDiv = path + @"\decimalsDiv.php";

				System.IO.FileStream streamSub = System.IO.File.Create(pathSub);
				streamSub.Close();
				streamSub.Dispose();
				System.IO.FileStream streamDiv = System.IO.File.Create(pathDiv);
				streamDiv.Close();
				streamDiv.Dispose();

				decimal maxPre = 4m;//12m;
				decimal init = 0m;
				decimal end = 5m;//100
				decimal step = 0.01m;//0.01

				System.IO.StreamWriter writterSub = System.IO.File.AppendText(pathSub);
				writterSub.WriteLine("<?php");
				writterSub.WriteLine("$return = array(");

				System.IO.StreamWriter writterDiv = System.IO.File.AppendText(pathDiv);
				writterDiv.WriteLine("<?php");
				writterDiv.WriteLine("$return = array(");

				for (decimal precision = maxPre; precision > 0; precision--)
				{
					for (decimal decimals = maxPre; decimals >= 0; decimals--)
					{
						decimal lInt = init;
						do
						{
							string sum;
							if (decimals == 0)

							{
								sum = "0";
							}
							else if (decimals == 1)
							{
								sum = "0.1";
							}
							else
							{
								sum = "0.";
								sum = sum.PadRight((int)(decimals + 1), '0') + "1";
							}
							NumberFormatInfo numinf = new NumberFormatInfo();
							numinf.NumberDecimalSeparator = ".";

							decimal left = decimal.Round(lInt, (int)precision, MidpointRounding.AwayFromZero);
							decimal right = decimal.Parse(sum, numinf);
							decimal resultSub = decimal.Round(left - right, (int)precision, MidpointRounding.AwayFromZero);
							
							string msgSub =
								String.Format("{0:0.##############}", left)
								+ ";" + String.Format("{0:0.##############}", right)
								+ ";" + String.Format("{0:0.##############}", resultSub)
								+ ";" + String.Format("{0:0.##############}", precision)
								+ ";" + String.Format("{0:0.##############}", decimals);


							//System.Console.WriteLine("array("+msg.Replace(",",".").Replace(";",",") + "),");
							writterSub.WriteLine("array(" + msgSub.Replace(",", ".").Replace(";", ",") + "),");
							
							if (right != 0m)
							{
								decimal resultDiv = decimal.Round(left/ right, (int)precision, MidpointRounding.AwayFromZero);

								string msgDiv =
									String.Format("{0:0.##############}", left)
									+ ";" + String.Format("{0:0.##############}", right)
									+ ";" + String.Format("{0:0.##############}", resultDiv)
									+ ";" + String.Format("{0:0.##############}", precision)
									+ ";" + String.Format("{0:0.##############}", decimals);

								writterDiv.WriteLine("array(" + msgDiv.Replace(",", ".").Replace(";", ",") + "),");
							}

							lInt += step;
							writterSub.Flush();
							writterDiv.Flush();

						}
						while (lInt <= end);
					}
				}

				writterSub.WriteLine(");");
				writterSub.WriteLine("");
				writterSub.Flush();
				writterSub.Close();
				writterSub.Dispose();

				writterDiv.WriteLine(");");
				writterDiv.WriteLine("");
				writterDiv.Flush();
				writterDiv.Close();
				writterDiv.Dispose();
			}
			catch (Exception e)
			{
				System.Console.WriteLine(e.Message);
			}
		}


	}
}
