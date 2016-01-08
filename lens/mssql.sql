if exists (select * from sysobjects where id = object_id(N'[dbo].[phplens]') and OBJECTPROPERTY(id, N'IsUserTable') = 1)
drop table [dbo].[phplens]
GO

CREATE TABLE [dbo].[phplens] (
	[id] [char] (12) NOT NULL ,
	[info] [char] (64) NULL ,
	[lastmod] [datetime] NOT NULL ,
	[data] [text] NULL 
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO

ALTER TABLE [dbo].[phplens] WITH NOCHECK ADD 
	CONSTRAINT [PK_phplens] PRIMARY KEY  NONCLUSTERED 
	(
		[id]
	)  ON [PRIMARY] 
GO

 CREATE  INDEX [IX_phplens] ON [dbo].[phplens]([lastmod]) ON [PRIMARY]
GO