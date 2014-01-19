<?php
// Farshad : Firewall is so neccessary if you aim for security of this website. make sure you don't mess up with the configuration
// Copyright: http://www.php-firewall.info/

/** IP Protected */
$IP_ALLOW = array();

/*

CREATE TABLE IF NOT EXISTS `nuke_guardian` (
  `config_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `config_value` longtext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`config_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `nuke_guardian`
--

INSERT INTO `nuke_guardian` (`config_name`, `config_value`) VALUES
('admin_contact', 0x7765626d617374657240796f7572736974652e636f6d),
('fw_pushmail', 0x30),
('fw_globals', 0x31),
('fw_ipdeny', 0x30),
('fw_ipspam', 0x30),
('disable_switch', 0x30),
('fw_ovh_ip', 0x30),
('fw_kimsufi_ip', 0x30),
('fw_dedibox_ip', 0x30),
('fw_digicube_ip', 0x30),
('fw_url', 0x30),
('fw_reqserver', 0x30),
('fw_flood', 0x30),
('fw_floodtime', 0x30),
('fw_santy', 0x30),
('fw_bots', 0x30),
('list_harvester', 0x407961686f6f2e636f6d0d0a616c657869626f740d0a616c6c696761746f720d0a616e6f6e796d697a0d0a61737465726961730d0a6261636b646f6f72626f740d0a626c61636b20686f6c650d0a626c61636b7769646f770d0a626c6f77666973680d0a626f74616c6f740d0a6275696c74626f74746f7567680d0a62756c6c736579650d0a62756e6e79736c6970706572730d0a63617463680d0a6365676266656965680d0a636861726f6e0d0a636865657365626f740d0a6368657272797069636b65720d0a6368696e61636c61770d0a636f6d62696e650d0a636f70797269676874636865636b0d0a636f736d6f730d0a6372657363656e740d0a6375726c0d0a6462726f7773650d0a646973636f0d0a646974746f7370796465720d0a646c6d616e0d0a646e6c6f61646d6167650d0a646f776e6c6f61640d0a647265616d70617373706f72740d0a647473206167656e740d0a6563617463680d0a656972677261626265720d0a65726f637261776c65720d0a657870726573732077656270696374757265730d0a657874726163746f7270726f0d0a6579656e657469650d0a66616e746f6d62726f777365720d0a66616e746f6d637265772062726f777365720d0a66696c65686561700d0a66696c65686f756e640d0a666c6173686765740d0a666f6f626f740d0a6672616e6b6c696e206c6f6361746f720d0a6672657368646f776e6c6f61640d0a6673637261776c65720d0a67616d657370795f6172636164650d0a676574626f740d0a67657472696768740d0a6765747765620d0a676f217a696c6c610d0a676f2d61686561642d676f742d69740d0a677261620d0a67726166756c610d0a6773612d637261776c65720d0a686172766573740d0a686c6f616465720d0a686d766965770d0a687474706c69620d0a68747470726573756d650d0a6874747261636b0d0a68756d616e6c696e6b730d0a696765747465720d0a696d6167652073747269707065720d0a696d616765207375636b65720d0a696e6475737472792070726f6772616d0d0a696e6479206c6962726172790d0a696e666f6e617669726f626f740d0a696e7374616c6c736869656c64206469676974616c77697a6172640d0a696e7465726765740d0a697269610d0a697276696e650d0a697570756920726573656172636820626f740d0a6a6268206167656e740d0a6a656e6e79626f740d0a6a65746361720d0a6a6f626f0d0a6a6f630d0a6b61706572650d0a6b656e6a696e207370696465720d0a6b6579776f72642064656e736974790d0a6c617262696e0d0a6c656563686674700d0a6c656563686765740d0a6c657869626f740d0a6c69627765622f636c73687474700d0a6c69627777772d7065726c0d0a6c696768746e696e67646f776e6c6f61640d0a6c696e636f6c6e207374617465207765622062726f777365720d0a6c696e6b657874726163746f7270726f0d0a6c696e6b7363616e2f382e31612e756e69780d0a6c696e6b77616c6b65720d0a6c77702d7472697669616c0d0a6c77703a3a73696d706c650d0a6d61632066696e6465720d0a6d61746120686172690d0a6d656469617365617263680d0a6d65746170726f64756374730d0a6d6963726f736f66742075726c20636f6e74726f6c0d0a6d69646f776e20746f6f6c0d0a6d69697870630d0a6d69737361756761206c6f636174650d0a6d6973736f75726920636f6c6c6567652062726f7773650d0a6d6973746572207069780d0a6d6f6765740d0a6d6f7a696c6c612e2a6e6577740d0a6d6f7a696c6c612f332e302028636f6d70617469626c65290d0a6d6f7a696c6c612f332e6d6f7a696c6c612f322e30310d0a6d73696520342e30202877696e3935290d0a6d756c7469626c6f636b65722062726f777365720d0a6d796461656d6f6e0d0a6d7967657472696768740d0a6e61626f740d0a6e6176726f61640d0a6e656172736974650d0a6e65742076616d706972650d0a6e6574616e74730d0a6e65746d656368616e69630d0a6e657470756d7065720d0a6e65747370696465720d0a6e6577736561726368656e67696e650d0a6e696365727370726f0d0a6e696e6a610d0a6e6974726f20646f776e6c6f616465720d0a6e70626f740d0a6f63746f7075730d0a6f66666c696e65206578706c6f7265720d0a6f66666c696e65206e6176696761746f720d0a6f70656e66696e640d0a70616765677261626265720d0a7061706120666f746f0d0a706176756b0d0a7062726f7773650d0a706362726f777365720d0a706576616c0d0a706f6d706f732f0d0a70726f6772616d207368617265776172650d0a70726f706f776572626f740d0a70726f77656277616c6b65720d0a70737572660d0a7075660d0a7075786172617069646f0d0a71756572796e206d6574617365617263680d0a7265616c646f776e6c6f61640d0a72656765740d0a7265706f6d6f6e6b65790d0a72737572660d0a72756d6f7572732d6167656e740d0a73616b7572610d0a7363616e346d61696c0d0a73656d616e746963646973636f766572790d0a73697465736e61676765720d0a736c797365617263680d0a7370616e6b626f740d0a7370616e6e6572200d0a7370696465727a696c6c610d0a7371207765627363616e6e65720d0a7374616d696e610d0a7374617220646f776e6c6f616465720d0a737465656c65720d0a0d0a73747269700d0a7375706572626f740d0a7375706572687474700d0a73757266626f740d0a73757a7572616e0d0a7377626f740d0a737a756b61637a0d0a74616b656f75740d0a74656c65706f72740d0a74656c65736f66740d0a74657374207370696465720d0a74686520696e747261666f726d616e740d0a7468656e6f6d61640d0a746967687474776174626f740d0a746974616e0d0a746f637261776c2f75726c646973706174636865720d0a747275655f726f626f740d0a74737572660d0a747572696e67206d616368696e650d0a747572696e676f730d0a75726c626c617a650d0a75726c67657466696c650d0a75726c79207761726e696e670d0a7574696c6d696e640d0a7663690d0a766f69646579650d0a77656220696d61676520636f6c6c6563746f720d0a776562207375636b65720d0a7765626175746f0d0a77656262616e6469740d0a776562636170747572650d0a776562636f6c6c6167650d0a776562636f706965720d0a776562656e68616e6365720d0a77656266657463680d0a776562676f0d0a7765626c6561636865720d0a7765626d6173746572776f726c64666f72756d626f740d0a776562716c0d0a7765627265617065720d0a7765627369746520657874726163746f720d0a7765627369746520717565737465720d0a776562737465720d0a77656273747269707065720d0a776562776861636b65720d0a776570207365617263680d0a776765740d0a7768697a62616e670d0a7769646f770d0a77696c64736f6674207375726665720d0a7777772d636f6c6c6563746f722d650d0a7777772e6e657477752e636f6d0d0a7777776f66666c650d0a78616c646f6e0d0a78656e750d0a7a6575730d0a7a696767790d0a7a69707079),
('list_referer', 0x31323168722e636f6d0d0a3173742d63616c6c2e6e65740d0a317374636f6f6c2e636f6d0d0a353030306e2e636f6d0d0a36392d7878782e636f6d0d0a3969726c2e636f6d0d0a3975792e636f6d0d0a612d6461792d61742d7468652d70617274792e636f6d0d0a61636365737374686570656163652e636f6d0d0a6164756c742d6d6f64656c2d6e7564652d70696374757265732e636f6d0d0a6164756c742d7365782d746f79732d667265652d706f726e2e636f6d0d0a61676e6974756d2e636f6d0d0a616c666f6e737361636b706665696666652e636f6d0d0a616c6f6e6777617966726f6d6d6172732e636f6d0d0a616e696d652d7365782d312e636f6d0d0a616e6f7265782d73662d7374696d756c616e742d667265652e636f6d0d0a616e7469626f742e6e65740d0a616e74697175652d746f6b6977612e636f6d0d0a61706f7468656b652d68657574652e636f6d0d0a61726d61646133312e636f6d0d0a61727461726b2e636f6d0d0a6172746c696c65692e636f6d0d0a617363656e646274672e636f6d0d0a61736368616c6165636865636b2e636f6d0d0a617369616e2d7365782d667265652d7365782e636f6d0d0a61736c6f77737065656b65722e636f6d0d0a6173736173696e6174656466726f67732e636f6d0d0a617468697273742d666f722d7472616e7175696c6c6974792e6e65740d0a6175626f6e70616e6965722e636f6d0d0a6176616c6f6e756d632e636f6d0d0a6179696e6762612e636f6d0d0a6261796f666e6f72657475726e2e636f6d0d0a6262773470686f6e657365782e636f6d0d0a62656572736172656e6f74667265652e636f6d0d0a62696572696b697565747363682e636f6d0d0a62696c696e6775616c616e6e6f756e63656d656e74732e636f6d0d0a626c61636b2d70757373792d746f6f6e2d636c69702d616e616c2d6c6f7665722d73696e676c652e636f6d0d0a626c6f776e61706172742e636f6d0d0a626c7565726f757465732e636f6d0d0a626f617365782e636f6d0d0a626f6f6b73616e6470616765732e636f6d0d0a626f6f74797175616b652e636f6d0d0a626f73737968756e7465722e636f6d0d0a626f797a2d7365782e636f6d0d0a62726f6b65727361616e64706f6b6572732e636f6d0d0a62726f7773657277696e646f77636c65616e65722e636f6d0d0a6275646f62797465732e636f6d0d0a627573696e6573733266756e2e636f6d0d0a6275796d79736869747a2e636f6d0d0a6279756e7461657365782e636f6d0d0a63616e69707574736f6d656c6f7665696e746f796f752e636f6d0d0a636172746f6f6e732e6e65742e72750d0a6361766572756e7361696c696e672e636f6d0d0a6365727461696e6865616c74682e636f6d0d0a636c616e7465612e636f6d0d0a636c6f73652d70726f74656374696f6e2d73657276696365732e636f6d0d0a636c756263616e696e6f2e636f6d0d0a636c7562737469632e636f6d0d0a636f6272616b61692d736b662e636f6d0d0a636f6c6c6567656675636b746f75722e636f2e756b0d0a636f6d6d616e6465727370616e6b2e636f6d0d0a636f6f6c656e61626c65642e636f6d0d0a6372757365636f756e7472796172742e636f6d0d0a63727573696e67666f727365782e636f2e756b0d0a63756e742d747761742d70757373792d6a756963652d636c69742d6c69636b696e672e636f6d0d0a637573746f6d657268616e647368616b65722e636f6d0d0a6379626f726772616d612e636f6d0d0a6461726b70726f666974732e636f2e756b0d0a646174696e67666f726d652e636f2e756b0d0a646174696e676d696e642e636f6d0d0a6465677265652e6f72672e72750d0a64656c6f72656e746f732e636f6d0d0a64696767796469676765722e636f6d0d0a64696e6b79646f6e6b796175737369652e636f6d0d0a646a7072697463686172642e636f6d0d0a646a746f702e636f6d0d0a64726175666765736368697373656e2e636f6d0d0a647265616d65727465656e732e636f2e756b0d0a65626f6e7961726368697665732e636f2e756b0d0a65626f6e79706c6179612e636f2e756b0d0a65636f6275696c646572323030302e636f6d0d0a656d61696c616e64656d61696c2e636f6d0d0a656d65646963692e6e65740d0a656e67696e652d6f6e2d666972652e636f6d0d0a65726f636974792e636f2e756b0d0a6573706f7274332e636f6d0d0a657465656e62616265732e636f6d0d0a6575726f6672656570616765732e636f6d0d0a6575726f746578616e732e636f6d0d0a65766f6c7563696f6e7765622e636f6d0d0a66616b6f6c692e636f6d0d0a66653462612e636f6d0d0a66657269656e736368776564656e2e636f6d0d0a66696e646c792e636f6d0d0a666972737474696d657465616472696e6b65722e636f6d0d0a66697368696e672e6e65742e72750d0a666c6174776f6e6b6572732e636f6d0d0a666c6f77657273686f70656e7465727461696e6d656e742e636f6d0d0a666c796d6172696f2e636f6d0d0a667265652d7878782d70696374757265732d706f726e6f2d67616c6c6572792e636f6d0d0a6672656562657374706f726e2e636f6d0d0a667265656675636b696e676d6f766965732e636f2e756b0d0a6672656578787873747566662e636f2e756b0d0a66727569746f6c6f676973742e6e65740d0a667275697473616e64626f6c74732e636f6d0d0a6675636b2d63756d73686f74732d667265652d6d69646765742d6d6f7669652d636c6970732e636f6d0d0a6675636b2d6d69636861656c6d6f6f72652e636f6d0d0a66756e64616365702e636f6d0d0a6761646c6573732e636f6d0d0a67616c6c617061676f7372616e676572732e636f6d0d0a67616c6c657269657334667265652e636f2e756b0d0a67616c6f66752e636f6d0d0a676179706978706f73742e636f2e756b0d0a67656f6d617374692e636f6d0d0a6769726c74696d652e636f2e756b0d0a676c617373726f70652e636f6d0d0a676f646a757374626c657373796f75616c6c2e636f6d0d0a676f6c64656e6167657265736f72742e636f6d0d0a676f6e6e616265646164646965732e636f6d0d0a6772616e616461736578692e636f6d0d0a0d0a6775617264696e67746865616e67656c732e636f6d0d0a67757970726f66696c65732e636f2e756b0d0a6861707079313232352e636f6d0d0a68617070796368617070797761636b792e636f6d0d0a6865616c74682e6f72672e72750d0a686578706c61732e636f6d0d0a686967686865656c736d6f64656c733466756e2e636f6d0d0a68696c6c737765622e636f6d0d0a68697074756e65722e636f6d0d0a686973746f7279696e746f73706163652e636f6d0d0a686f612d74756f692e636f6d0d0a686f6d65627579696e67696e61746c616e74612e636f6d0d0a686f72697a6f6e756c7472612e636f6d0d0a686f7273656d696e6961747572652e6e65740d0a686f746b6973732e636f2e756b0d0a686f746c6976656769726c732e636f2e756b0d0a686f746d6174636875702e636f2e756b0d0a6875736c65722e636f2e756b0d0a6961656e7465727461696e6d656e742e636f6d0d0a69616d6e6f74736f6d656f6e652e636f6d0d0a69636f6e736f66636f7272757074696f6e2e636f6d0d0a69686176656e6f7472757374696e796f752e636f6d0d0a696e666f726d61742d73797374656d732e636f6d0d0a696e746572696f7270726f73686f702e636f6d0d0a696e746572736f66746e6574776f726b732e636f6d0d0a696e746865637269622e636f6d0d0a696e766573746d656e743463617368696572732e636f6d0d0a6974692d747261696c6572732e636f6d0d0a6a61636b706f742d6861636b65722e636f6d0d0a6a61636b732d776f726c642e636f6d0d0a6a616d65737468657361696c6f726261736865722e636f6d0d0a6a65737569736c656d6f6e64732e636f6d0d0a6a757374616e6f74686572646f6d61696e6e616d652e636f6d0d0a6b616d70656c69636b612e636f6d0d0a6b616e616c72617474656e61727363682e636f6d0d0a6b61747a61736865722e636f6d0d0a6b65726f73696e6a756e6b69652e636f6d0d0a6b696c6c6173766964656f2e636f6d0d0a6b6f656e6967737069737365722e636f6d0d0a6b6f6e746f72706172612e636f6d0d0a6c38742e636f6d0d0a6c616573746163696f6e3130312e636f6d0d0a6c616d62757363686c616d7070656e2e636f6d0d0a6c616e6b617365782e636f2e756b0d0a6c617365722d6372656174696f6e732e636f6d0d0a6c652d746f75722d64752d6d6f6e64652e636f6d0d0a6c6563726166742e636f6d0d0a6c65646f2d64657369676e2e636f6d0d0a6c656674726567697374726174696f6e2e636f6d0d0a6c656b6b696b6f6f6d61737461732e636f6d0d0a6c65706f6d6d6561752e636f6d0d0a6c6962722d616e696d616c2e636f6d0d0a6c69627261726965732e6f72672e72750d0a6c696b6577617465726c696b6577696e642e636f6d0d0a6c696d626f6a756d706572732e636f6d0d0a6c696e6b2e72750d0a6c6f636b706f72746c696e6b732e636f6d0d0a6c6f6970726f6a6563742e636f6d0d0a6c6f6e677465726d616c7465726e6174697665732e636f6d0d0a6c6f74746f65636f2e636f6d0d0a6c7563616c6f7a7a692e636f6d0d0a6d616b692d652d70656e732e636f6d0d0a6d616c65706179706572766965772e636f2e756b0d0a6d616e6761786f786f2e636f6d0d0a6d6170732e6f72672e72750d0a6d6172636f6669656c64732e636f6d0d0a6d61737465726f666368656573652e636f6d0d0a6d61737465726f66746865626c617374657268696c6c2e636f6d0d0a6d6173746865616477616e6b6572732e636f6d0d0a6d65676166726f6e746965722e636f6d0d0a6d65696e736368757070656e2e636f6d0d0a6d6572637572796261722e636f6d0d0a6d65746170616e6e61732e636f6d0d0a6d6963656c656272652e636f6d0d0a6d69646e696768746c61756e64726965732e636f6d0d0a6d696b6561706172746d656e742e636f2e756b0d0a6d696c6c656e6e69756d63686f7275732e636f6d0d0a6d696d756e6469616c323030322e636f6d0d0a6d696e69617475726567616c6c6572796d6d2e636f6d0d0a6d697874617065726164696f2e636f6d0d0a6d6f6e6469616c636f72616c2e636f6d0d0a6d6f6e6a612d77616b616d617473752e636f6d0d0a6d6f6e737465726d6f6e6b65792e6e65740d0a6d6f75746866726573686e6572732e636f6d0d0a6d756c6c656e73686f6c696461792e636f6d0d0a6d7573696c6f2e636f6d0d0a6d79686f6c6c6f776c6f672e636f6d0d0a6d79686f6d6570686f6e656e756d6265722e636f6d0d0a6d796b6579626f617264697362726f6b656e2e636f6d0d0a6d79736f6669612e6e65740d0a6e616b65642d63686561746572732e636f6d0d0a6e616b65642d6f6c642d776f6d656e2e636f6d0d0a6e617374796769726c732e636f2e756b0d0a6e6174696f6e636c616e2e6e65740d0a6e61747465727261747465722e636f6d0d0a6e6175676874796164616d2e636f6d0d0a6e65737462657363686d75747a65722e636f6d0d0a6e657477752e636f6d0d0a6e65777265616c656173656f6e6c696e652e636f6d0d0a6e65777265616c65617365736f6e6c696e652e636f6d0d0a6e65787466726f6e74696572736f6e6c696e652e636f6d0d0a6e696b6f73746178692e636f6d0d0a6e6f746f72696f7573372e636f6d0d0a6e7265637275697465722e636f6d0d0a6e757273696e676465706f742e636f6d0d0a6e75737472616d6f7373652e636f6d0d0a6e75747572616c6869636b732e636f6d0d0a6f6363617a2d6175746f34392e636f6d0d0a6f6365616e2d64622e6e65740d0a6f696c6275726e6572736572766963652e6e65740d0a6f6d6275726f2e636f6d0d0a6f6e656f7a2e636f6d0d0a6f6e657061676561686561642e6e65740d0a6f6e6c696e6577697468616c696e652e636f6d0d0a6f7267616e697a6174652e6e65740d0a6f75726f776e77656464696e67736f6e672e636f6d0d0a6f77656e2d6d757369632e636f6d0d0a702d706172746e6572732e636f6d0d0a706167696e6164656175746f722e636f6d0d0a70616b697374616e64757479667265652e636f6d0d0a70616d616e646572736f6e2e636f2e756b0d0a706172656e7473656e73652e6e65740d0a7061727469636c65776176652e6e65740d0a7061792d636c69632e636f6d0d0a706179346c696e6b2e6e65740d0a70636973702e636f6d0d0a706572736973742d706861726d612e636f6d0d0a7065746562616e642e636f6d0d0a706574706c7573696e6469612e636f6d0d0a7069636b616262772e636f2e756b0d0a706963747572652d6f72616c2d706f736974696f6e2d6c65736269616e2e636f6d0d0a706c38616761696e2e636f6d0d0a706c616e6574696e672e6e65740d0a706f7075736b792e636f6d0d0a706f726e2d6578706572742e636f6d0d0a70726f6d6f626c69747a612e636f6d0d0a70726f70726f64756374732d7573612e636f6d0d0a707463677a6f6e652e636f6d0d0a7074706f726e2e636f6d0d0a7075626c6973686d79626f6e672e636f6d0d0a70757474696e67746f6765746865722e636f6d0d0a7175616c696669656463616e63656c6174696f6e732e636f6d0d0a7261686f73742e636f6d0d0a7261696e626f7732312e636f6d0d0a72616b6b617368616b6b612e636f6d0d0a72616e646f6d66656564696e672e636f6d0d0a726170652d6172742e636f6d0d0a72642d627261696e732e636f6d0d0a7265616c6573746174656f6e74686568696c6c2e6e65740d0a72656275736361646f626f740d0a7265717565737465642d73747566662e636f6d0d0a726574726f747261736865722e636f6d0d0a7269636f706f7369746976652e636f6d0d0a7269736f727365696e726574652e636f6d0d0a726f746174696e6763756e74732e636f6d0d0a72756e61776179636c69636b732e636f6d0d0a727574616c696272652e636f6d0d0a732d6d61726368652e636f6d0d0a736162726f736f6a617a7a2e636f6d0d0a73616d75726169646f6a6f2e636f6d0d0a73616e616c64617262652e636f6d0d0a73617373656d696e6172732e636f6d0d0a7363686c616d70656e6272757a7a6c65722e636f6d0d0a7365617263686d79626f6e672e636f6d0d0a7365636b75722e636f6d0d0a7365782d617369616e2d706f726e2d696e74657272616369616c2d70686f746f2e636f6d0d0a7365782d706f726e2d6675636b2d68617264636f72652d6d6f7669652e636f6d0d0a73657861332e6e65740d0a73657865722e636f6d0d0a736578696e74656e74696f6e2e636f6d0d0a7365786e657432342e74760d0a7365786f6d756e646f2e636f6d0d0a736861726b732e636f6d2e72750d0a7368656c6c732e636f6d2e72750d0a73686f702d65636f736166652e636f6d0d0a73686f702d746f6f6e2d68617264636f72652d6675636b2d63756d2d706963732e636f6d0d0a73696c76657266757373696f6e732e636f6d0d0a73696e2d636974792d7365782e6e65740d0a736c75697376616e2e636f6d0d0a736d757473686f74732e636f6d0d0a736e6167676c6572736d6167676c65722e636f6d0d0a736f6d657468696e67746f666f7267657469742e636f6d0d0a736f7068696573706c6163652e6e65740d0a736f757273757368692e636f6d0d0a736f75746865726e78737461626c65732e636f6d0d0a73706565643436372e636f6d0d0a737065656470616c34796f752e636f6d0d0a73706f7274792e6f72672e72750d0a73746f7064726976696e672e6e65740d0a7374772e6f72672e72750d0a73756666696369656e746c6966652e636f6d0d0a737573736578626f6174732e6e65740d0a7377696e6765722d70617274792d667265652d646174696e672d706f726e2d736c7574732e636f6d0d0a7379646e65796861792e636f6d0d0a737a6d6a68742e636f6d0d0a74656e696e636874726f75742e636f6d0d0a74686562616c616e6365646672756974732e636f6d0d0a746865656e646f6674686573756d6d69742e636f6d0d0a7468697377696c6c626569742e636f6d0d0a74686f736574686f736574686f73652e636f6d0d0a74696379636c65736f66696e6469612e636f6d0d0a746974732d6761792d6661676f742d626c61636b2d746974732d626967746974732d616d61746575722e636f6d0d0a746f6e6975732e636f6d0d0a746f6f68736f66742e636f6d0d0a746f6f6c76616c6c65792e636f6d0d0a746f6f706f726e6f2e6e65740d0a746f6f73657875616c2e636f6d0d0a746f726e6761742e636f6d0d0a746f75722e6f72672e72750d0a746f776e656c75787572792e636f6d0d0a747261666669636d6f676765722e636f6d0d0a74726961636f6163682e6e65740d0a74726f7474696e626f622e636f6d0d0a7474746672616d65732e636f6d0d0a74766a756b65626f782e6e65740d0a756e6465726376722e636f6d0d0a756e66696e69736865642d646573697265732e636f6d0d0a756e69636f726e6f6e65726f2e636f6d0d0a756e696f6e76696c6c65666972652e636f6d0d0a757073616e646f776e732e636f6d0d0a757074686568696c6c616e64646f776e2e636f6d0d0a76616c6c61727461766964656f2e636f6d0d0a766965746e616d646174696e6773657276696365732e636f6d0d0a76696e656761726c656d6f6e73686f74732e636f6d0d0a76697a792e6e65742e72750d0a766e6c6164696573646174696e6773657276696365732e636f6d0d0a766f6d6974616e646275737465642e636f6d0d0a77616c6b696e6774686577616c6b696e672e636f6d0d0a77656c6c2d492d616d2d7468652d747970652d6f662d626f792e636f6d0d0a7768616c65732e636f6d2e72750d0a7768696e6365722e6e65740d0a776869747061676573726970706572732e636f6d0d0a77686f69732e73630d0a776970706572726970706572732e636f6d0d0a776f726466696c65626f6f6b6c6574732e636f6d0d0a776f726c642d736578732e636f6d0d0a787361792e636f6d0d0a787878636879616e67656c2e636f6d0d0a787878783a0d0a7878787a6970732e636f6d0d0a796f756172656c6f7374696e7472616e7369742e636f6d0d0a797570706965736c6f766573746f636b732e636f6d0d0a79757a686f75687561676f6e672e636f6d0d0a7a68616f72692d666f6f642e636f6d0d0a7a77696562656c6261636b652e636f6d),
('list_string', ''),
('fw_rqmethod', 0x30),
('page_delay', 0x35),
('fw_dos', 0x30),
('fw_unionsql', 0x30),
('fw_click', 0x30),
('fw_xss', 0x31),
('fw_cookies', 0x30),
('fw_post', 0x30),
('fw_get', 0x30),
('fw_ovh', 0x30),
('fw_kimsufi', 0x30),
('fw_dedibox', 0x30),
('fw_digicube', 0x30),
('track_clear', 0x30),
('track_max', 0x363034383030),
('track_perpage', 0x3530),
('track_sort_column', 0x36),
('track_sort_direction', 0x64657363),
('disable_from_date', 0x323031312d30332d323820323a30343a3234),
('disable_to_date', 0x323031312d30332d333120363a32353a3334),
('disable_reason', '');

*/
/** configuration define */
define('PHP_FIREWALL_LANGUAGE', 'Persian' );
define('PHP_FIREWALL_ADMIN_MAIL', '' );
define('PHP_FIREWALL_PUSH_MAIL', false );
define('PHP_FIREWALL_LOG_FILE', 'logs' );
define('PHP_FIREWALL_PROTECTION_UNSET_GLOBALS', false );
define('PHP_FIREWALL_PROTECTION_RANGE_IP_DENY', false );
define('PHP_FIREWALL_PROTECTION_RANGE_IP_SPAM', false );
define('PHP_FIREWALL_PROTECTION_URL', false );
define('PHP_FIREWALL_PROTECTION_REQUEST_SERVER', false );
define('PHP_FIREWALL_ANTI_FLOOD', false );
define('PHP_FIREWALL_ANTI_FLOOD_TIME', 1 );
define('PHP_FIREWALL_PROTECTION_SANTY', true );
define('PHP_FIREWALL_PROTECTION_BOTS', true );
define('PHP_FIREWALL_PROTECTION_REQUEST_METHOD', true );
define('PHP_FIREWALL_PROTECTION_DOS', true );
define('PHP_FIREWALL_PROTECTION_UNION_SQL', true );
define('PHP_FIREWALL_PROTECTION_CLICK_ATTACK', true );
define('PHP_FIREWALL_PROTECTION_XSS_ATTACK', true );
define('PHP_FIREWALL_PROTECTION_COOKIES', false );
define('PHP_FIREWALL_PROTECTION_POST', false );
define('PHP_FIREWALL_PROTECTION_GET', false );
define('PHP_FIREWALL_PROTECTION_SERVER_OVH', false );
define('PHP_FIREWALL_PROTECTION_SERVER_KIMSUFI', false );
define('PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX', false );
define('PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE', false );
define('PHP_FIREWALL_PROTECTION_SERVER_OVH_BY_IP', false );
define('PHP_FIREWALL_PROTECTION_SERVER_KIMSUFI_BY_IP', false );
define('PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX_BY_IP', false );
define('PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE_BY_IP', false );
/** end configuration */

/** IPS PROTECTED */
if ( count( $IP_ALLOW ) > 0 ) {
	if ( in_array( $_SERVER['REMOTE_ADDR'], $IP_ALLOW ) ) return;
}
/** END IPS PROTECTED */

if ( PHP_FIREWALL_ACTIVATION === true ) {

	FUNCTION PHP_FIREWALL_unset_globals() {
		if ( ini_get('register_globals') ) {
			$allow = array('_ENV' => 1, '_GET' => 1, '_POST' => 1, '_COOKIE' => 1, '_FILES' => 1, '_SERVER' => 1, '_REQUEST' => 1, 'GLOBALS' => 1);
			foreach ($GLOBALS as $key => $value) {
				if ( ! isset( $allow[$key] ) ) unset( $GLOBALS[$key] );
			}
		}
	}

	if ( PHP_FIREWALL_PROTECTION_UNSET_GLOBALS === true ) PHP_FIREWALL_unset_globals();

	/** fonctions de base */
	FUNCTION PHP_FIREWALL_get_env($st_var) {
		global $HTTP_SERVER_VARS;
		if(isset($_SERVER[$st_var])) {
			return strip_tags( $_SERVER[$st_var] );
		} elseif(isset($_ENV[$st_var])) {
			return strip_tags( $_ENV[$st_var] );
		} elseif(isset($HTTP_SERVER_VARS[$st_var])) {
			return strip_tags( $HTTP_SERVER_VARS[$st_var] );
		} elseif(getenv($st_var)) {
			return strip_tags( getenv($st_var) );
		} elseif(function_exists('apache_getenv') && apache_getenv($st_var, true)) {
			return strip_tags( apache_getenv($st_var, true) );
		}
		return '';
	}

	FUNCTION PHP_FIREWALL_get_referer() {
		if( PHP_FIREWALL_get_env('HTTP_REFERER') )
			return PHP_FIREWALL_get_env('HTTP_REFERER');
		return 'no referer';
	}

	FUNCTION PHP_FIREWALL_get_ip() {
		if ( PHP_FIREWALL_get_env('HTTP_X_FORWARDED_FOR') ) {
			return PHP_FIREWALL_get_env('HTTP_X_FORWARDED_FOR');
		} elseif ( PHP_FIREWALL_get_env('HTTP_CLIENT_IP') ) {
			return PHP_FIREWALL_get_env('HTTP_CLIENT_IP');
		} else {
			return PHP_FIREWALL_get_env('REMOTE_ADDR');
		}
	}
	FUNCTION PHP_FIREWALL_get_user_agent() {
		if(PHP_FIREWALL_get_env('HTTP_USER_AGENT'))
			return PHP_FIREWALL_get_env('HTTP_USER_AGENT');
		return 'none';
	}

	FUNCTION PHP_FIREWALL_get_query_string() {
		if( PHP_FIREWALL_get_env('QUERY_STRING') )
			return str_replace('%09', '%20', PHP_FIREWALL_get_env('QUERY_STRING'));
		return '';
	}
	FUNCTION PHP_FIREWALL_get_request_method() {
		if(PHP_FIREWALL_get_env('REQUEST_METHOD'))
			return PHP_FIREWALL_get_env('REQUEST_METHOD');
		return 'none';
	}
	FUNCTION PHP_FIREWALL_gethostbyaddr() {
		if ( PHP_FIREWALL_PROTECTION_SERVER_OVH === true OR PHP_FIREWALL_PROTECTION_SERVER_KIMSUFI === true OR PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX === true OR PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE === true ) {
			if ( @ empty( $_SESSION['PHP_FIREWALL_gethostbyaddr'] ) ) {
				return $_SESSION['PHP_FIREWALL_gethostbyaddr'] = @gethostbyaddr( PHP_FIREWALL_get_ip() );
			} else {
				return strip_tags( $_SESSION['PHP_FIREWALL_gethostbyaddr'] );
			}
		}
	}

	/** bases define */
	define('PHP_FIREWALL_GET_QUERY_STRING', strtolower( PHP_FIREWALL_get_query_string() ) );
	define('PHP_FIREWALL_USER_AGENT', PHP_FIREWALL_get_user_agent() );
	define('PHP_FIREWALL_GET_IP', PHP_FIREWALL_get_ip() );
	define('PHP_FIREWALL_GET_HOST', PHP_FIREWALL_gethostbyaddr() );
	define('PHP_FIREWALL_GET_REFERER', PHP_FIREWALL_get_referer() );
	define('PHP_FIREWALL_GET_REQUEST_METHOD', PHP_FIREWALL_get_request_method() );
	define('PHP_FIREWALL_REGEX_UNION','#\w?\s?union\s\w*?\s?(select|all|distinct|insert|update|drop|delete)#is');
	FUNCTION PHP_FIREWALL_push_email( $subject, $msg ) {
		$headers = "From: PHP Firewall: ".PHP_FIREWALL_ADMIN_MAIL." <".PHP_FIREWALL_ADMIN_MAIL.">\r\n"
			."Reply-To: ".PHP_FIREWALL_ADMIN_MAIL."\r\n"
			."Priority: urgent\r\n"
			."Importance: High\r\n"
			."Precedence: special-delivery\r\n"
			."Organization: PHP Firewall\r\n"
			."MIME-Version: 1.0\r\n"
			."Content-Type: text/plain\r\n"
			."Content-Transfer-Encoding: 8bit\r\n"
			."X-Priority: 1\r\n"
			."X-MSMail-Priority: High\r\n"
			."X-Mailer: PHP/" . phpversion() ."\r\n"
			."X-PHPFirewall: 1.0 by PHPFirewall\r\n"
			."Date:" . date("D, d M Y H:s:i") . " +0100\n";
		if ( PHP_FIREWALL_ADMIN_MAIL != '' )
			@mail( PHP_FIREWALL_ADMIN_MAIL, $subject, $msg, $headers );
	}

	FUNCTION PHP_FIREWALL_LOGS( $type ) {
		$f = fopen( dirname(__FILE__).'/'.PHP_FIREWALL_LOG_FILE.'.txt', 'a');
		$msg = date('j-m-Y H:i:s')." | $type | IP: ".PHP_FIREWALL_GET_IP." ] | DNS: ".gethostbyaddr(PHP_FIREWALL_GET_IP)." | Agent: ".PHP_FIREWALL_USER_AGENT." | URL: ".PHP_FIREWALL_REQUEST_URI." | Referer: ".PHP_FIREWALL_GET_REFERER."\n\n";
		fputs($f, $msg);
		fclose($f);
		if ( PHP_FIREWALL_PUSH_MAIL === true ) {
			PHP_FIREWALL_push_email( 'Alert PHP Firewall '.strip_tags( $_SERVER['SERVER_NAME'] ) , "PHP Firewall logs of ".strip_tags( $_SERVER['SERVER_NAME'] )."\n".str_replace('|', "\n", $msg ) );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_OVH === true ) {
		if ( stristr( PHP_FIREWALL_GET_HOST ,'ovh') ) {
			PHP_FIREWALL_LOGS( 'OVH Server list' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_OVH );
			exit();
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_OVH_BY_IP === true ) {
		$ip = explode('.', PHP_FIREWALL_GET_IP );
		if ( $ip[0].'.'.$ip[1] == '87.98' or  $ip[0].'.'.$ip[1] == '91.121' or  $ip[0].'.'.$ip[1] == '94.23' or $ip[0].'.'.$ip[1] == '213.186' or  $ip[0].'.'.$ip[1] == '213.251' ) {
			PHP_FIREWALL_LOGS( 'OVH Server IP' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_OVH );
			exit();
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_KIMSUFI === true ) {
		if ( stristr( PHP_FIREWALL_GET_HOST ,'kimsufi') ) {
			PHP_FIREWALL_LOGS( 'KIMSUFI Server list' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_KIMSUFI );
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX === true ) {
		if ( stristr( PHP_FIREWALL_GET_HOST ,'dedibox') ) {
			PHP_FIREWALL_LOGS( 'DEDIBOX Server list' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_DEDIBOX );
			exit();
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_DEDIBOX_BY_IP === true ) {
		$ip = explode('.', PHP_FIREWALL_GET_IP );
		if ( $ip[0].'.'.$ip[1] == '88.191' ) {
			PHP_FIREWALL_LOGS( 'DEDIBOX Server IP' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_DEDIBOX_IP );
			exit();
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE === true ) {
		if ( stristr( PHP_FIREWALL_GET_HOST ,'digicube') ) {
			PHP_FIREWALL_LOGS( 'DIGICUBE Server list' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_DIGICUBE );
			exit();
		}
	}

	if ( PHP_FIREWALL_PROTECTION_SERVER_DIGICUBE_BY_IP === true ) {
		$ip = explode('.', PHP_FIREWALL_GET_IP );
		if ( $ip[0].'.'.$ip[1] == '95.130' ) {
			PHP_FIREWALL_LOGS( 'DIGICUBE Server IP' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_DIGICUBE_IP );
			exit();
		}
	}

	if ( PHP_FIREWALL_PROTECTION_RANGE_IP_SPAM === true ) {
		$ip_array = array('24', '186', '189', '190', '200', '201', '202', '209', '212', '213', '217', '222' );
		$range_ip = explode('.', PHP_FIREWALL_GET_IP );
		if ( in_array( $range_ip[0], $ip_array ) ) {
			PHP_FIREWALL_LOGS( 'IPs Spam list' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_SPAM );
			exit();
		}
	}

	if ( PHP_FIREWALL_PROTECTION_RANGE_IP_DENY === true ) {
		$ip_array = array('0', '1', '2', '5', '10', '14', '23', '27', '31', '36', '37', '39', '42', '46', '49', '50', '100', '101', '102', '103', '104', '105', '106', '107', '114', '172', '176', '177', '179', '181', '185', '192', '223', '224' );
		$range_ip = explode('.', PHP_FIREWALL_GET_IP );
		if ( in_array( $range_ip[0], $ip_array ) ) {
			PHP_FIREWALL_LOGS( 'IPs reserved list' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_SPAM_IP );
			exit();
		}
	}

	if ( PHP_FIREWALL_PROTECTION_COOKIES === true ) {
		$ct_rules = Array('applet', 'base', 'bgsound', 'blink', 'embed', 'expression', 'frame', 'javascript', 'layer', 'link', 'meta', 'object', 'onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload', 'script', 'style', 'title', 'vbscript', 'xml');
		if ( PHP_FIREWALL_PROTECTION_COOKIES === true ) {
			foreach($_COOKIE as $value) {
				$check = str_replace($ct_rules, '*', $value);
				if( $value != $check ) {
					PHP_FIREWALL_LOGS( 'Cookie protect' );
					unset( $value );
				}
			}
		}
		if ( PHP_FIREWALL_PROTECTION_POST === true ) {
			foreach( $_POST as $value ) {
				$check = str_replace($ct_rules, '*', $value);
				if( $value != $check ) {
					PHP_FIREWALL_LOGS( 'POST protect' );
					unset( $value );
				}
			}
		}
		if ( PHP_FIREWALL_PROTECTION_GET === true ) {
			foreach( $_GET as $value ) {
				$check = str_replace($ct_rules, '*', $value);
				if( $value != $check ) {
					PHP_FIREWALL_LOGS( 'GET protect' );
					unset( $value );
				}
			}
		}
	}

	
	
	
	/** protection : Anti Flood */
	if ( PHP_FIREWALL_ANTI_FLOOD === true ) {
		if (!isset($_SESSION)) {
			session_start();
		}
		
		IF($_SESSION['last_session_request'] > TIME() - PHP_FIREWALL_ANTI_FLOOD_TIME){
			header( 'Content-Type: text/html; charset=UTF-8' );
			die(PHP_FIREWALL_ANTI_FLOOD_TIME);//If user request a page refresh less than 2 seconds.
			exit();
		}
	$_SESSION['last_session_request'] = TIME();
	}
	
	
	/** protection de l'url */
	if ( PHP_FIREWALL_PROTECTION_URL === true ) {
		$ct_rules = array( 'absolute_path', 'ad_click', 'alert(', 'alert%20', ' and ', 'basepath', 'bash_history', '.bash_history', 'cgi-', 'chmod(', 'chmod%20', '%20chmod', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', '/chown', 'chgrp(', 'chr(', 'chr=', 'chr%20', '%20chr', 'chunked', 'cookie=', 'cmd', 'cmd=', '%20cmd', 'cmd%20', '.conf', 'configdir', 'config.php', 'cp%20', '%20cp', 'cp(', 'diff%20', 'dat?', 'db_mysql.inc', 'document.location', 'document.cookie', 'drop%20', 'echr(', '%20echr', 'echr%20', 'echr=', '}else{', '.eml', 'esystem(', 'esystem%20', '.exe',  'exploit', 'file\://', 'fopen', 'fwrite', '~ftp', 'ftp:', 'ftp.exe', 'getenv', '%20getenv', 'getenv%20', 'getenv(', 'grep%20', '_global', 'global_', 'global[', 'http:', '_globals', 'globals_', 'globals[', 'grep(', 'g\+\+', 'halt%20', '.history', '?hl=', '.htpasswd', 'http_', 'http-equiv', 'http/1.', 'http_php', 'http_user_agent', 'http_host', '&icq', 'if{', 'if%20{', 'img src', 'img%20src', '.inc.php', '.inc', 'insert%20into', 'ISO-8859-1', 'ISO-', 'javascript\://', '.jsp', '.js', 'kill%20', 'kill(', 'killall', '%20like', 'like%20', 'locate%20', 'locate(', 'lsof%20', 'mdir%20', '%20mdir', 'mdir(', 'mcd%20', 'motd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', 'mcd(', 'mrd(', 'mcd=', 'mod_gzip_status', 'modules/', 'mrd=', 'mv%20', 'nc.exe', 'new_password', 'nigga(', '%20nigga', 'nigga%20', '~nobody', 'org.apache', '+outfile+', '%20outfile%20', '*/outfile/*',' outfile ','outfile', 'password=', 'passwd%20', '%20passwd', 'passwd(', 'phpadmin', 'perl%20', '/perl', 'phpbb_root_path','*/phpbb_root_path/*','p0hh', 'ping%20', '.pl', 'powerdown%20', 'rm(', '%20rm', 'rmdir%20', 'mv(', 'rmdir(', 'phpinfo()', '<?php', 'reboot%20', '/robot.txt' , '~root', 'root_path', 'rush=', '%20and%20', '%20xorg%20', '%20rush', 'rush%20', 'secure_site, ok', 'select%20', 'select from', 'select%20from', '_server', 'server_', 'server[', 'server-info', 'server-status', 'servlet', 'sql=', '<script', '<script>', '</script','script>','/script', 'switch{','switch%20{', '.system', 'system(', 'telnet%20', 'traceroute%20', '.txt', 'union%20', '%20union', 'union(', 'union=', 'vi(', 'vi%20', 'wget', 'wget%20', '%20wget', 'wget(', 'window.open', 'wwwacl', ' xor ', 'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', '$_request', '$_get', '$request', '$get',  '&aim', '/etc/password','/etc/shadow', '/etc/groups', '/etc/gshadow', '/bin/ps', 'uname\x20-a', '/usr/bin/id', '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/usr/bin', 'bin/python', 'bin/tclsh', 'bin/nasm', '/usr/x11r6/bin/xterm', '/bin/mail', '/etc/passwd', '/home/ftp', '/home/www', '/servlet/con', '?>', '.txt');
		$check = str_replace($ct_rules, '*', PHP_FIREWALL_GET_QUERY_STRING );
		if( PHP_FIREWALL_GET_QUERY_STRING != $check ) {
			PHP_FIREWALL_LOGS( 'URL protect' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_URL );
			exit();
		}
	}

	/** Posting from other servers in not allowed */
	if ( PHP_FIREWALL_PROTECTION_REQUEST_SERVER === true ) {
		if ( PHP_FIREWALL_GET_REQUEST_METHOD == 'POST' ) {
			if (isset($_SERVER['HTTP_REFERER'])) {
				if ( ! stripos( $_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'], 0 ) ) {
					PHP_FIREWALL_LOGS( 'Posting another server' );
					header( 'Content-Type: text/html; charset=UTF-8' );
					die( _PHPF_PROTECTION_OTHER_SERVER );
					exit();
				}
			}
		}
	}

	/** protection contre le vers santy */
	if ( PHP_FIREWALL_PROTECTION_SANTY === true ) {
		$ct_rules = array('rush','highlight=%','perl','chr(','pillar','visualcoder','sess_');
		$check = str_replace($ct_rules, '*', strtolower(PHP_FIREWALL_REQUEST_URI) );
		if( strtolower(PHP_FIREWALL_REQUEST_URI) != $check ) {
			PHP_FIREWALL_LOGS( 'Santy' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_SANTY );
			exit();
		}
	}

	/** protection bots */
	if ( PHP_FIREWALL_PROTECTION_BOTS === true ) {
		$ct_rules = array( '@nonymouse', 'addresses.com', 'ideography.co.uk', 'adsarobot', 'ah-ha', 'aktuelles', 'alexibot', 'almaden', 'amzn_assoc', 'anarchie', 'art-online', 'aspseek', 'assort', 'asterias', 'attach', 'atomz', 'atspider', 'autoemailspider', 'backweb', 'backdoorbot', 'bandit', 'batchftp', 'bdfetch', 'big.brother', 'black.hole', 'blackwidow', 'blowfish', 'bmclient', 'boston project', 'botalot', 'bravobrian', 'buddy', 'bullseye', 'bumblebee ', 'builtbottough', 'bunnyslippers', 'capture', 'cegbfeieh', 'cherrypicker', 'cheesebot', 'chinaclaw', 'cicc', 'civa', 'clipping', 'collage', 'collector', 'copyrightcheck', 'cosmos', 'crescent', 'custo', 'cyberalert', 'deweb', 'diagem', 'digger', 'digimarc', 'diibot', 'directupdate', 'disco', 'dittospyder', 'download accelerator', 'download demon', 'download wonder', 'downloader', 'drip', 'dsurf', 'dts agent', 'dts.agent', 'easydl', 'ecatch', 'echo extense', 'efp@gmx.net', 'eirgrabber', 'elitesys', 'emailsiphon', 'emailwolf', 'envidiosos', 'erocrawler', 'esirover', 'express webpictures', 'extrac', 'eyenetie', 'fastlwspider', 'favorg', 'favorites sweeper', 'fezhead', 'filehound', 'filepack.superbr.org', 'flashget', 'flickbot', 'fluffy', 'frontpage', 'foobot', 'galaxyBot', 'generic', 'getbot ', 'getleft', 'getright', 'getsmart', 'geturl', 'getweb', 'gigabaz', 'girafabot', 'go-ahead-got-it', 'go!zilla', 'gornker', 'grabber', 'grabnet', 'grafula', 'green research', 'harvest', 'havindex', 'hhjhj@yahoo', 'hloader', 'hmview', 'homepagesearch', 'htmlparser', 'hulud', 'http agent', 'httpconnect', 'httpdown', 'http generic', 'httplib', 'httrack', 'humanlinks', 'ia_archiver', 'iaea', 'ibm_planetwide', 'image stripper', 'image sucker', 'imagefetch', 'incywincy', 'indy', 'infonavirobot', 'informant', 'interget', 'internet explore', 'infospiders',  'internet ninja', 'internetlinkagent', 'interneteseer.com', 'ipiumbot', 'iria', 'irvine', 'jbh', 'jeeves', 'jennybot', 'jetcar', 'joc web spider', 'jpeg hunt', 'justview', 'kapere', 'kdd explorer', 'kenjin.spider', 'keyword.density', 'kwebget', 'lachesis', 'larbin',  'laurion(dot)com', 'leechftp', 'lexibot', 'lftp', 'libweb', 'links aromatized', 'linkscan', 'link*sleuth', 'linkwalker', 'libwww', 'lightningdownload', 'likse', 'lwp','mac finder', 'mag-net', 'magnet', 'marcopolo', 'mass', 'mata.hari', 'mcspider', 'memoweb', 'microsoft url control', 'microsoft.url', 'midown', 'miixpc', 'minibot', 'mirror', 'missigua', 'mister.pix', 'mmmtocrawl', 'moget', 'mozilla/2', 'mozilla/3.mozilla/2.01', 'mozilla.*newt', 'multithreaddb', 'munky', 'msproxy', 'nationaldirectory', 'naverrobot', 'navroad', 'nearsite', 'netants', 'netcarta', 'netcraft', 'netfactual', 'netmechanic', 'netprospector', 'netresearchserver', 'netspider', 'net vampire', 'newt', 'netzip', 'nicerspro', 'npbot', 'octopus', 'offline.explorer', 'offline explorer', 'offline navigator', 'opaL', 'openfind', 'opentextsitecrawler', 'orangebot', 'packrat', 'papa foto', 'pagegrabber', 'pavuk', 'pbwf', 'pcbrowser', 'personapilot', 'pingalink', 'pockey', 'program shareware', 'propowerbot/2.14', 'prowebwalker', 'proxy', 'psbot', 'psurf', 'puf', 'pushsite', 'pump', 'qrva', 'quepasacreep', 'queryn.metasearch', 'realdownload', 'reaper', 'recorder', 'reget', 'replacer', 'repomonkey', 'rma', 'robozilla', 'rover', 'rpt-httpclient', 'rsync', 'rush=', 'searchexpress', 'searchhippo', 'searchterms.it', 'second street research', 'seeker', 'shai', 'sitecheck', 'sitemapper', 'sitesnagger', 'slysearch', 'smartdownload', 'snagger', 'spacebison', 'spankbot', 'spanner', 'spegla', 'spiderbot', 'spiderengine', 'sqworm', 'ssearcher100', 'star downloader', 'stripper', 'sucker', 'superbot', 'surfwalker', 'superhttp', 'surfbot', 'surveybot', 'suzuran', 'sweeper', 'szukacz/1.4', 'tarspider', 'takeout', 'teleport', 'telesoft', 'templeton', 'the.intraformant', 'thenomad', 'tighttwatbot', 'titan', 'tocrawl/urldispatcher','toolpak', 'traffixer', 'true_robot', 'turingos', 'turnitinbot', 'tv33_mercator', 'uiowacrawler', 'urldispatcherlll', 'url_spider_pro', 'urly.warning ', 'utilmind', 'vacuum', 'vagabondo', 'vayala', 'vci', 'visualcoders', 'visibilitygap', 'vobsub', 'voideye', 'vspider', 'w3mir', 'webauto', 'webbandit', 'web.by.mail', 'webcapture', 'webcatcher', 'webclipping', 'webcollage', 'webcopier', 'webcopy', 'webcraft@bea', 'web data extractor', 'webdav', 'webdevil', 'webdownloader', 'webdup', 'webenhancer', 'webfetch', 'webgo', 'webhook', 'web.image.collector', 'web image collector', 'webinator', 'webleacher', 'webmasters', 'webmasterworldforumbot', 'webminer', 'webmirror', 'webmole', 'webreaper', 'websauger', 'websaver', 'website.quester', 'website quester', 'websnake', 'websucker', 'web sucker', 'webster', 'webreaper', 'webstripper', 'webvac', 'webwalk', 'webweasel', 'webzip', 'wget', 'widow', 'wisebot', 'whizbang', 'whostalking', 'wonder', 'wumpus', 'wweb', 'www-collector-e', 'wwwoffle', 'wysigot', 'xaldon', 'xenu', 'xget', 'x-tractor', 'zeus' );
		$check = str_replace($ct_rules, '*', strtolower(PHP_FIREWALL_USER_AGENT) );
		if( strtolower(PHP_FIREWALL_USER_AGENT) != $check ) {
			PHP_FIREWALL_LOGS( 'Bots attack' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_BOTS );
			exit();
		}
	}

	/** Invalid request method check */
	if ( PHP_FIREWALL_PROTECTION_REQUEST_METHOD === true ) {
		if(strtolower(PHP_FIREWALL_GET_REQUEST_METHOD)!='get' AND strtolower(PHP_FIREWALL_GET_REQUEST_METHOD)!='head' AND strtolower(PHP_FIREWALL_GET_REQUEST_METHOD)!='post' AND strtolower(PHP_FIREWALL_GET_REQUEST_METHOD)!='put') {
			PHP_FIREWALL_LOGS( 'Invalid request' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_REQUEST );
			exit();
		}
	}

	/** protection dos attaque */
	if ( PHP_FIREWALL_PROTECTION_DOS === true ) {
		if ( !defined('PHP_FIREWALL_USER_AGENT')  || PHP_FIREWALL_USER_AGENT == '-' ) {
			PHP_FIREWALL_LOGS( 'Dos attack' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_DOS );
			exit();
		}
	}

	/** protection union sql attaque */
	if ( PHP_FIREWALL_PROTECTION_UNION_SQL === true ) {
		$stop = 0;
		$ct_rules = array( '*/from/*', '*/insert/*', '+into+', '%20into%20', '*/into/*', ' into ', 'into', '*/limit/*', 'not123exists*', '*/radminsuper/*', '*/select/*', '+select+', '%20select%20', ' select ',  '+union+', '%20union%20', '*/union/*', ' union ', '*/update/*', '*/where/*' );
		$check    = str_replace($ct_rules, '*', PHP_FIREWALL_GET_QUERY_STRING );
		if( PHP_FIREWALL_GET_QUERY_STRING != $check ) $stop++;
		if (preg_match(PHP_FIREWALL_REGEX_UNION, PHP_FIREWALL_GET_QUERY_STRING)) $stop++;
		if (preg_match('/([OdWo5NIbpuU4V2iJT0n]{5}) /', rawurldecode( PHP_FIREWALL_GET_QUERY_STRING ))) $stop++;
		if (strstr(rawurldecode( PHP_FIREWALL_GET_QUERY_STRING ) ,'*')) $stop++;
		if ( !empty( $stop ) ) {
			PHP_FIREWALL_LOGS( 'Union attack' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_UNION );
			exit();
		}
	}

	/** protection click attack */
	if ( PHP_FIREWALL_PROTECTION_CLICK_ATTACK === true ) {
		$ct_rules = array( '/*', 'c2nyaxb0', '/*' );
		if( PHP_FIREWALL_GET_QUERY_STRING != str_replace($ct_rules, '*', PHP_FIREWALL_GET_QUERY_STRING ) ) {
			PHP_FIREWALL_LOGS( 'Click attack' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_CLICK );
			exit();
		}
	}

	/** protection XSS attack */
	if ( PHP_FIREWALL_PROTECTION_XSS_ATTACK === true ) {
		$ct_rules = array( 'http\:\/\/', 'https\:\/\/', 'cmd=', '&cmd', 'exec', 'concat', './', '../',  'http:', 'h%20ttp:', 'ht%20tp:', 'htt%20p:', 'http%20:', 'https:', 'h%20ttps:', 'ht%20tps:', 'htt%20ps:', 'http%20s:', 'https%20:', 'ftp:', 'f%20tp:', 'ft%20p:', 'ftp%20:', 'ftps:', 'f%20tps:', 'ft%20ps:', 'ftp%20s:', 'ftps%20:', '.php?url=' );
		$check    = str_replace($ct_rules, '*', PHP_FIREWALL_GET_QUERY_STRING );
		if( PHP_FIREWALL_GET_QUERY_STRING != $check ) {
			PHP_FIREWALL_LOGS( 'XSS attack' );
			header( 'Content-Type: text/html; charset=UTF-8' );
			die( _PHPF_PROTECTION_XSS );
			exit();
		}
	}
	
	// Lets ban some IPs huh ?!
	include_once("ipban.php");
}