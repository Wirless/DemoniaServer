    DataDir = "data/"
    sqlType = "mysql"
    
	sqlHost = "127.0.0.1"
	sqlPort = 3306
	sqlUser = "root"
	sqlPass = ""
	sqlDatabase = "ots"
	sqlKeepAlive = 0
	mysqlReadTimeout = 100
	mysqlWriteTimeout = 100
	mysqlReconnectionAttempts = 3
	encryptionType = "sha1"
	
	accountManager = false
	namelockManager = false
	newPlayerChooseVoc = false
	newPlayerSpawnPosX = 857
	newPlayerSpawnPosY = 964
	newPlayerSpawnPosZ = 7
	newPlayerTownId = 12
	newPlayerLevel = 1
	newPlayerMagicLevel = 0
	generateAccountNumber = false
	generateAccountSalt = false

	useRookSystem = true
	rookTownId = 12
	rookLevelToGetRooked = 5
	rookLevelToLeaveRook = 8

	useFragHandler = true
	redSkullLength = 1 * 24 * 60 * 60
	fragsLimit = 6 * 60 * 60
	fragsSecondLimit = 3 * 24 * 60 * 60
	fragsThirdLimit = 7 * 24 * 60 * 60
	advancedFragList = false
	broadcastBanishments = true
	autoBanishUnknownBytes = true
	TimeToDecreaseFrags = 4 * 60 * 60 * 1000
	KillsToRedSkull = 6
	KillsToBan = 10
	BanLengthUnjust = 1 * 48 * 60 * 60
	WarningsToFinalBanUnjust = 3
	FinalBanLengthUnjust = 7 * 24 * 60 * 60
	
	notationsToBan = 3
	warningsToFinalBan = 4
	warningsToDeletion = 5
	banLength = 3 * 12 * 60 * 60
	killsBanLength = 3 * 24 * 60 * 60
	finalBanLength = 7 * 24 * 60 * 60
	ipBanLength = 1 * 24 * 60 * 60
	allowedMaxSizePackets = 30

	worldType = "open"
	protectionLevel = 5
	pvpTileIgnoreLevelAndVocationProtection = true
	pzLocked = 60 * 1000
	huntingDuration = 15 * 1000
	criticalHitChance = 7
	criticalHitMultiplier = 1
	displayCriticalHitNotify = false
	removeWeaponAmmunition = true
	removeWeaponCharges = true
	removeRuneCharges = true
	whiteSkullTime = 15 * 60 * 1000
	noDamageToSameLookfeet = false
	showHealthChange = false
	showManaChange = false
	showHealthChangeForMonsters = false
	showManaChangeForMonsters = false
	fieldOwnershipDuration = 5 * 1000
	stopAttackingAtExit = false
	deathLostPercent = 10
	pushCreatureDelay = 1 * 1000
	deathContainerId = 1987
	gainExperienceColor = 215
	addManaSpentInPvPZone = false
	recoverManaAfterDeathInPvPZone = false
	squareColor = 2
	allowFightback = false
	fistBaseAttack = 10
	useFairfightReduction = true
	optionalWarAttackableAlly = false

	worldId = 0
	ip = "54.37.88.137"
	useProxyServer = false
	usProxyIp = "84.203.25.227"
	brProxyIp = "84.203.25.227"
	bindOnlyGlobalAddress = false
	loginPort = 7171
	gamePort = 7172
	loginTries = 300
	retryTimeout = 5 * 1000
	loginTimeout = 60 * 1000
	maxPlayers = 1000
	motd = "Trapera.eu BETA-TESTS!"
	displayOnOrOffAtCharlist = true
	charlistBasicInfo = true
	onePlayerOnlinePerAccount = false
	allowClones = 0
	serverName = "Trapera"
	serverProxyName = "Proxy US"
	loginMessage = "Welcome to the Trapera.EU 7.4!"
	statusTimeout = 5 * 60 * 1000
	replaceKickOnLogin = true
	forceSlowConnectionsToDisconnect = false
	loginOnlyWithLoginServer = false
	premiumPlayerSkipWaitList = false
	packetsPerSecond = 50
	

	deathListEnabled = true
	deathListRequiredTime = 1 * 60 * 1000
	deathAssistCount = 0
	maxDeathRecords = 5
	multipleNames = false

	externalGuildWarsManagement = true
	ingameGuildManagement = false
	levelToFormGuild = 8
	premiumDaysToFormGuild = 0
	guildNameMinLength = 4
	guildNameMaxLength = 20

	buyableAndSellableHouses = true
	houseNeedPremium = true
	bedsRequirePremium = true
	levelToBuyHouse = 1
	housesPerAccount = 1
	houseRentAsPrice = true
	housePriceAsRent = false
	housePriceEachSquare = 700
	houseSkipInitialRent = true
	houseRentPeriod = "none"
	houseCleanOld = 0
	guildHalls = false
	houseProtection = false
	enableCast = true

	timeBetweenActions = 500
	timeBetweenExActions = 1000
	timeBetweenCustomActions = 500
	hotkeyAimbotEnabled = false
	tibiaClassicSlots = true

	mapName = "world.otbm"
	mapAuthor = ""
	randomizeTiles = true
	storeTrash = true
	cleanProtectedZones = true

	mailboxDisabledTowns = "12"
	mailMaxAttempts = 20
	mailBlockPeriod = 60 * 60 * 1000
	mailAttemptsFadeTime = 10 * 60 * 1000

	daemonize = false
	defaultPriority = "high"
	niceLevel = 5
	serviceThreads = 1
	coresUsed = "-1"

	startupDatabaseOptimization = false
	updatePremiumStateAtStartup = true
	skipItemsVersionCheck = false

	bufferMutedOnSpellFailure = false
	spellNameInsteadOfWords = false
	emoteSpells = true
	unifiedSpells = false
	runesHitTopCreature = false

	allowChangeOutfit = true
	allowChangeColors = true
	disableOutfitsForPrivilegedPlayers = false

	dataDirectory = "data/"
	logsDirectory = "data/logs/"
	bankSystem = true
	promptExceptionTracerErrorBox = true
	maximumDoorLevel = 500
	maxMessageBuffer = 10
	logPlayersStatements = true
	tradeLimit = 100
	useCapacity = true
	tileHeightBlock = true
	autoStack = true
	playerFollowExhaust = 0

	-- Party
	-- NOTE: experienceShareLevelDifference is float number.
	-- experienceShareLevelDifference is highestLevel * value
	experienceShareRadiusX = 30
	experienceShareRadiusY = 30
	experienceShareRadiusZ = 2
	experienceShareLevelDifference = 2 / 3
	extraPartyExperienceLimit = 100
	extraPartyExperiencePercent = 25
	experienceShareActivity = 2 * 60 * 1000
	
	
	defaultDepotSizePremium = 2000
	defaultDepotSize = 1000

	separateVipListPerCharacter = false
	vipListDefaultLimit = 20
	vipListDefaultPremiumLimit = 100

	houseDataStorage = "binary"
	saveGlobalStorage = false
	storePlayerDirection = true
	savePlayerData = true

	ghostModeInvisibleEffect = false
	ghostModeSpellEffects = true

	idleWarningTime = 14 * 60 * 1000
	idleKickTime = 15 * 60 * 1000
	reportsExpirationAfterReads = 1
	playerQueryDeepness = -1
	tileLimit = 0
	protectionTileLimit = 0
	houseTileLimit = 0

	freePremium = false
	premiumForPromotion = false

	blessings = true
	blessingOnlyPremium = true
	blessingReductionBase = 1
	blessingReductionDecrement = 1
	eachBlessReduction = 1
	pvpBlessingThreshold = 25
	fairFightTimeRange = 60

	experienceStages = true
	rateExperience = 1.0
	rateExperienceFromPlayers = 2
	rateSkill = 4.0
	rateMagic = 3.0
	rateLoot = 2.5
	offlineRateSkill = 3.0
	offlineRateMagic = 3.0
	rateSpawn = 1
	rateSpawnMin = 1
	rateSpawnMax = 1

	rateMonsterHealth = 1.0
	rateMonsterMana = 1.0
	rateMonsterAttack = 1.0
	rateMonsterDefense = 1.0

	minLevelThresholdForKilledPlayer = 0.7
	maxLevelThresholdForKilledPlayer = 2

	useStamina = false
	rateStaminaLoss = 1
	rateStaminaGain = 3
	rateStaminaThresholdGain = 12
	staminaRatingLimitTop = 40 * 60
	staminaRatingLimitBottom = 14 * 60
	staminaLootLimit = 14 * 60
	rateStaminaAboveNormal = 1.5
	rateStaminaUnderNormal = 0.5
	staminaThresholdOnlyPremium = true

	globalSaveEnabled = true
	globalSaveHour = 14
	globalSaveMinute = 10
	shutdownAtGlobalSave = true
	cleanMapAtGlobalSave = true
	closeInstanceOnShutdown = true

	deSpawnRange = 0
	deSpawnRadius = 0
	monsterSpawnWalkback = false
	allowBlockSpawn = true

	maxPlayerSummons = 2
	summonsDropCorpse = true
	teleportAllSummons = false
	teleportPlayerSummons = false

	statusPort = 7171
	ownerName = "The Janusze"
	ownerEmail = "selppkez@gmail.com"
	url = "http://trapera.eu/"
	location = "Europe"
	displayGamemastersWithOnlineCommand = false

	disableLuaErrors = false
	displayPlayersLogging = true
	prefixChannelLogs = ""
	runFile = ""
	outputLog = ""
	truncateLogOnStartup = false
	
